@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="account-form">
            <form method="post" action="{{route('user.store.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row gy-4">
                    <h4 id="createModalLabel"> @lang('Add New Store')</h4>
                    <div class="col-12 form-group">
                        <label class="form--label">@lang('Name')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control form--control" value="{{ old('name') }}" name="name" placeholder="@lang('Name')" required>
                        </div>
                    </div>
            
                    <div class="col-12 form-group">
                        <label class="form--label">@lang('Image')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control form--control"  name="image" required>
                        </div>
                        <p class="fs-12">@lang('Recomended size:: 160x70 px.')</p>
                    </div>
                    <div class="col-12 form-group">
                        <label class="form--label">@lang('Description')</label>
                        <div class="col-sm-12">
                            <textarea class="form-control form--control" name="description" placeholder="@lang('Description')"></textarea>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn--base btn-global" id="btn-save"
                        value="add">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 