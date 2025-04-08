@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body px-4">
                    <form method="post" action="{{route('admin.coupon.update', $coupon->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Title') </label>
                                    <input type="text" class="form-control" name="title" placeholder="@lang('Title')"
                                         value="{{$coupon->title}}" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Category') </label>
{{--                                    <select class="form-control" name="category_id" required>--}}
{{--                                        @foreach($categories as $item)--}}
{{--                                            <option value="{{$item->id}}" {{$item->id== $coupon->category_id ? "selected" : ''}}> {{__($item->name)}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
                                    <select class="form-control" name="category_id">
                                        <option value="">@lang('Select Parent Category')</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $coupon->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @if ($category->children->count() > 0)
                                                @foreach ($category->children as $child)
                                                    <option value="{{ $child->id }}" {{ $child->id == $coupon->category_id ? 'selected' : '' }}>
                                                        -- {{ $child->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Store')</label>
                                    <select class="form-control" name="store_id" required>
                                        @foreach($stores as $item)
                                            <option value="{{$item->id}}" {{$item->id== $coupon->store_id ? "selected" : ''}}> {{__($item->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Path') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Path')"
                                           name="path" value="{{$coupon->path}}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Code') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Code')"
                                        name="code" value="{{$coupon->code}}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Link') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Link')"
                                        name="link" value="{{$coupon->link}}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Start Date') </label>
                                    <input type="date" class="form-control" placeholder="@lang('Start Date')"
                                        name="start_date" value="{{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') : '' }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('End Date') </label>
                                    <input type="date" class="form-control" placeholder="@lang('End Date')"
                                        name="expire_date" value="{{ $coupon->expire_date ? \Carbon\Carbon::parse($coupon->expire_date)->format('Y-m-d') : '' }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Image') </label>
                                    <input type="file" class="form-control"  name="image">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="type" class="font-weight-bold">@lang('Status')</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{$coupon->status ==1 ?"selected": ""}}>@lang('Active')</option>
                                        <option value="0" {{$coupon->status ==0 ?"selected": ""}}>@lang('Inactive')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Description') </label>
                                    <textarea name="description" class="form-control" id="description">@php echo $coupon->description; @endphp</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-4">
                                    <label class="fw-bold" for="is_featured">@lang('Is Featured')</label>
                                    <label class="switch m-0" for="is_featured">
                                        <input type="checkbox" class="toggle-switch" name="is_featured" id="is_featured" {{ $coupon->is_featured ?
                                            'checked' : null }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-4">
                                    <label class="fw-bold" for="is_exclusive">@lang('Is Exclusive')</label>
                                    <label class="switch m-0" for="is_exclusive">
                                        <input type="checkbox" class="toggle-switch" name="is_exclusive"  id="is_exclusive" {{ $coupon->is_exclusive ?
                                            'checked' : null }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-4">
                                    <label class="fw-bold" for="is_deal">@lang('Is Deal')</label>
                                    <label class="switch m-0" for="is_deal">
                                        <input type="checkbox" class="toggle-switch" name="is_deal"  id="is_deal" {{ $coupon->is_deal ?
                                            'checked' : null }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <button type="submit" class="btn btn--primary btn-global">@lang('Update')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
