<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Pagination\LengthAwarePaginator;


class LanguageController extends Controller
{

    public function langManage($lang = false)
    {
        $pageTitle = 'Manage Languages';
        $languages = Language::orderBy('is_default','desc')->get();
        return view('admin.language.lang', compact('pageTitle', 'languages'));
    }

    public function langStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'code' => 'required|string|max:40|unique:languages'
        ]);

        function find_lang_strings($directory, &$strings) {
            $pattern = "/@lang\\('(.*?)'\\)/"; // define the regular expression pattern

            if (is_dir($directory)) {
                $files = scandir($directory); // get a list of files in the directory

                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $path = $directory . '/' . $file;

                        if (is_dir($path)) {
                            find_lang_strings($path, $strings); // recursively search subdirectories
                        } else {
                            $content = file_get_contents($path); // read the file contents
                            preg_match_all($pattern, $content, $matches); // search for the pattern in the content

                            foreach ($matches[1] as $match) {
                                $strings[] = $match; // add the matched string to the array
                            }
                        }
                    }
                }
            }
        }

        $directory = base_path('resources/views'); // get the path to the views directory
        $strings = array(); // initialize an array to store the strings
        find_lang_strings($directory, $strings); // call the recursive function to search the directory

        $lang = array();
        foreach ($strings as $string) {
            $lang[$string] = $string; // use the string as both the key and the value
        }

        $json = json_encode($lang, JSON_PRETTY_PRINT); // convert the array to a JSON string
        $json_file = strtolower($request->code) . '.json';
        file_put_contents(resource_path('lang/') . $json_file, $json); // write the JSON string to a file


        $language = new  Language();

        if ($request->is_default) {
            $lang = $language->where('is_default', 1)->first();
            if ($lang) {
                $lang->is_default = 0;
                $lang->save();
            }
        }
        $language->name = $request->name;
        $language->code = strtolower($request->code);
        $language->is_default = $request->is_default ? 1 : 0;
        $language->save();

        $notify[] = ['success', 'Language has been added successfully'];
        return back()->withNotify($notify);
    }

    public function langUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $language = Language::findOrFail($id);

        if (!$request->is_default) {
            $defaultLang = Language::where('is_default', 1)->where('id','!=',$id)->exists();
            if (!$defaultLang) {
                $notify[] = ['error','You\'ve to set another language as default before unset this'];
                return back()->withNotify($notify);
            }
        }

        $language->name = $request->name;
        $language->is_default = $request->is_default ? 1 : 0;
        $language->save();

        if ($request->is_default) {
            $lang = Language::where('is_default', 1)->where('id','!=',$language->id)->first();
            if ($lang) {
                $lang->is_default = 0;
                $lang->save();
            }
        }

        $notify[] = ['success', 'Update successfully'];
        return back()->withNotify($notify);
    }

    public function langDelete($id)
    {
        $lang = Language::find($id);
        fileManager()->removeFile(resource_path('lang/') . $lang->code . '.json');
        $lang->delete();
        $notify[] = ['success', 'Language has been deleted successfully'];
        return back()->withNotify($notify);
    }
    public function langEdit($id)
    {
        $lang = Language::find($id);
        $pageTitle = "Update " . $lang->name . " Keywords";
        $jsonPath = resource_path('lang/') . $lang->code . '.json';

        if (!file_exists($jsonPath)) {
            $notify[] = ['error', 'File not found'];
            return back()->withNotify($notify);
        }

        $jsonData = file_get_contents($jsonPath);
        $data = json_decode($jsonData, true);

        $perPage = 20; // Number of items per page
        $page = request('page', 1); // Get the current page from the query string
        $offset = ($page - 1) * $perPage;
        $paginatedData = array_slice($data, $offset, $perPage, true);
        $paginatedData = new LengthAwarePaginator($paginatedData, count($data), $perPage, $page);
        $paginatedData->setPath(url()->current());
        // dd($paginatedData);

        $list_lang = Language::all();

        return view('admin.language.edit_lang', compact('pageTitle', 'paginatedData', 'lang', 'list_lang'));
    }


    public function langImport(Request $request)
    {
        $tolang = Language::find($request->toLangid);
        $fromLang = Language::find($request->id);
        $json = file_get_contents(resource_path('lang/') . $fromLang->code . '.json');

        $json_arr = json_decode($json, true);

        file_put_contents(resource_path('lang/') . $tolang->code . '.json', json_encode($json_arr));

        return 'success';
    }

    public function storeLanguageJson(Request $request, $id)
    {
        $lang = Language::find($id);
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required'
        ]);

        $items = file_get_contents(resource_path('lang/') . $lang->code . '.json');

        $reqKey = trim($request->key);

        if (array_key_exists($reqKey, json_decode($items, true))) {
            $notify[] = ['error', "Key already exist"];
            return back()->withNotify($notify);
        } else {
            $newArr[$reqKey] = trim($request->value);
            $itemData = json_decode($items, true);
            $result = array_merge($itemData, $newArr);
            file_put_contents(resource_path('lang/') . $lang->code . '.json', json_encode($result));
            $notify[] = ['success', "Language key has been added successfully"];
            return back()->withNotify($notify);
        }

    }
    public function deleteLanguageJson(Request $request, $id)
    {
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required'
        ]);

        $key = $request->key;
        $lang = Language::find($id);
        $data = file_get_contents(resource_path('lang/') . $lang->code . '.json');

        $json_arr = json_decode($data, true);
        unset($json_arr[$key]);

        file_put_contents(resource_path('lang/'). $lang->code . '.json', json_encode($json_arr));
        $notify[] = ['success', "Language key has been deleted successfully"];
        return back()->withNotify($notify);
    }
    public function updateLanguageJson(Request $request, $id)
    {
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required'
        ]);

        $key = trim($request->key);
        $reqValue = $request->value;
        $lang = Language::find($id);

        $data = file_get_contents(resource_path('lang/') . $lang->code . '.json');

        $json_arr = json_decode($data, true);

        $json_arr[$key] = $reqValue;

        file_put_contents(resource_path('lang/'). $lang->code . '.json', json_encode($json_arr));

        $notify[] = ['success', 'Language key has been updated successfully'];
        return back()->withNotify($notify);
    }

}
