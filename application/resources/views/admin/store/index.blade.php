@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Image')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stores as $item)
                            <tr>
                                <td>{{__($item->name)}}</td>
                                <td><img src="{{ getImage(getFilePath('store') . '/' . $item->image) }}" alt="@lang('store-image')" style="width: 50px"></td>
                                <td>
                                    @if($item->status == 1)
                                    
                                    <span class="badge badge--success">@lang('Active')</span>
                                    @else 
                                    
                                    <span class="badge badge--danger">@lang('Inactive')</span>
                                    @endif
                                </td>
                                <td>                                    
                                    <div class="button--group">
                                        @if($item->user_id == 0)
                                            <button title="@lang('Edit')"
                                                class="btn btn-sm btn--success editBtn" data-id="{{$item->id}}" data-status="{{$item->status}}" data-name="{{$item->name}}" data-description="{{$item->description}}">
                                                <i class="la la-edit"></i>
                                            </button>
                                        @endif
                                        
                                        <button title="@lang('Change Status')"
                                        data-id="{{$item->id}}"
                                        class="btn btn-sm btn--primary changeStatusBtn">
                                        <i class="las la-check"></i>
                                        </button>
                                        <button title="@lang('Delete')"
                                            class="btn btn-sm btn--danger ms-1 deleteBtn" data-id="{{$item->id}}">
                                            <i class="la la-trash"></i>
                                        </button>
                                     
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table><!-- table end -->
                  
                </div>
            </div>
            @if ($stores->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($stores) }}
            </div>
        @endif
        </div><!-- card end -->
    </div>
</div>

{{-- NEW MODAL --}}
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel"> @lang('Add New Store')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="{{ route('admin.store.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row form-group">
                        <label>@lang('Name')</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{ old('name') }}" name="name" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label>@lang('Image')</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control"  name="image" required>
                        </div>
                        <p class="fs-12">@lang('Recomended size:: 160x70 px.')</p>
                    </div>
                    <div class="row form-group">
                        <label>@lang('Description')</label>
                        <div class="col-sm-12">
                            <textarea class="form-control"  name="description" > </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                        value="add">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">@lang('Update Store')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="{{route('admin.store.update')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="row form-group">
                        <label>@lang('Name')</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{ old('name') }}" name="name" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label>@lang('Image')</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control"  name="image" >
                        </div>
                        <p class="fs-12">@lang('Recomended size:: 160x70 px.')</p>
                    </div>
                    <div class="row form-group">
                        <label>@lang('Description')</label>
                        <div class="col-sm-12">
                            <textarea class="form-control"  name="description" > </textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label>@lang('status')</label>
                        <div class="col-sm-12">
                            <select name="status" class="form-control">
                                <option value="0" {{ @$item->status == 0 ? 'selected' : '' }}>@lang('Inactive')</option>
                                <option value="1" {{ @$item->status == 1 ? 'selected' : '' }}>@lang('Active')</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                        value="add">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- DELETE  MODAL --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">@lang('Delete Confirmation')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="{{route('admin.store.delete')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                   <span>@lang('Are You Sure Delete This Store')</span>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                        value="add">@lang('Delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- status change modal --}}
<div id="statusModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-2">@lang('Status Change Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.store.status.change')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to') <span class="fw-bold">@lang('see')</span> <span
                            class="fw-bold withdraw-amount text-success"></span> @lang('status change') <span
                            class="fw-bold withdraw-user"></span>?
                    </p>
                    <div class="form-group">
                        <label for="status" class="font-weight-bold">@lang('Status')</label>
                        <select name="status" class="form-select" id="status">
                            <option value="1">@lang('Approved')</option>
                            <option value="0">@lang('Pending')</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitButton" class="btn btn--primary btn-global">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div
@endsection

@push('breadcrumb-plugins')
<a class="btn btn-sm btn--primary" data-bs-toggle="modal" data-bs-target="#createModal"><i
        class="las la-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";
        $('.editBtn').on('click', function () {
            var modal = $('#editModal');

            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('textarea[name=description]').val($(this).data('description'));
            
            var statusValue = $(this).data('status');
            modal.find('select[name=status]').val(statusValue);
           
            modal.modal('show');
        });

        $('.deleteBtn').on('click', function () {
            var modal = $('#deleteModal');
            modal.find('input[name=id]').val($(this).data('id'));

            modal.modal('show');

        });
        
        // change status
        $('.changeStatusBtn').on('click', function () {
            var modal = $('#statusModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

        
    })(jQuery);
</script>
@endpush