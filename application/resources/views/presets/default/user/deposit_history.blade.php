@extends($activeTemplate.'layouts.master')
@section('content')


<div class="account-form">
    <form action="">
        <div class="mb-3 d-flex justify-content-end">
            <div class="input--group trans-search d-flex">
                <input type="text" name="search" class="form--control" value="{{ request()->search }}"
                    placeholder="@lang('Search by transactions')">
                <button class="input-group-text bg--base text-white">
                    <i class="las la-search"></i>
                </button>
            </div>
        </div>
    </form>
    <div class="card custom--card">
        <div class="card-body p-0">
            <div class="table-responsive--sm table-responsive">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th>@lang('Gateway')</th>
                            <th class="text-center">@lang('Initiated')</th>
                            <th class="text-center">@lang('Amount')</th>
                            <th class="text-center">@lang('Conversion')</th>
                            <th class="text-center">@lang('Status')</th>
                            <th>@lang('Details')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deposits as $deposit)
                        <tr>
                            <td data-label="Gateway">
                                <span class="fw-bold"> 
                                    <span class="text-primary">{{
                                        __($deposit->gateway?->name) }}
                                    </span> 
                                </span>

                            </td>

                            <td class="text-center" data-label="Initiated">
                                {{ showDateTime($deposit->created_at) }}
                            </td>
                            <td class="text-center" data-label="Amount">
                                <strong title="@lang('Amount with charge')">
                                    {{ showAmount($deposit->amount+$deposit->charge) }} {{
                                    __($general->cur_text) }}
                                </strong>
                            </td>
                            <td class="text-center" data-label="Conversion">
                                <strong>{{ showAmount($deposit->final_amo) }}
                                    {{__($deposit->method_currency)}}</strong>
                            </td>
                            <td class="text-center" data-label="Status">
                                @php echo $deposit->statusBadge @endphp
                            </td>
                            @php
                            $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
                            @endphp

                            <td data-label="Details">
                                <a href="javascript:void(0)"
                                    class="btn btn--base btn--sm @if($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                    @if($deposit->method_code >= 1000)
                                    data-info="{{ $details }}"
                                    @endif
                                    @if ($deposit->status == 3)
                                    data-admin_feedback="{{ $deposit->admin_feedback }}"
                                    @endif
                                    >
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if($deposits->hasPages())
    <div class="d-flex justify-content-end mt-4 mb-2">
        {{ $deposits->links() }}
    </div>
    @endif
</div>


{{-- APPROVE MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <ul class="list-group userData mb-2">
                </ul>
                <div class="feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        $('.detailBtn').on('click', function () {
            var modal = $('#detailModal');

            var userData = $(this).data('info');
            var html = '';
            if (userData) {
                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                    }
                });
            }

            modal.find('.userData').html(html);

            if ($(this).data('admin_feedback') != undefined) {
                var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
            } else {
                var adminFeedback = '';
            }

            modal.find('.feedback').html(adminFeedback);


            modal.modal('show');
        });
    })(jQuery);

</script>
@endpush