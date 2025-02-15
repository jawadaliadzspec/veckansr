@extends($activeTemplate.'layouts.master')
@section('content')

<div class="account-form">
    <div class="row justify-content-center">
        <div class="col-lg-12 ">
            <form action="">
                <div class="mb-3 d-flex justify-content-end text-right">
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
                    <div class="table-responsive">
                        <table class="table table--responsive--lg">
                            <thead>
                                <tr>
                                    <th>@lang('Gateway')</th>
                                    <th class="text-center">@lang('Initiated')</th>
                                    <th class="text-center">@lang('Amount')</th>
                                    <th class="text-center">@lang('Conversion')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($withdraws as $withdraw)
                                <tr>
                                    <td data-label="Gateway">
                                        <span class="fw-bold"><span class="text-primary"> {{
                                                __(@$withdraw->method->name) }}</span></span>
                                    </td>
                                    <td class="text-center" data-label="Initiated">
                                        {{ showDateTime($withdraw->created_at) }} <br> {{
                                        diffForHumans($withdraw->created_at) }}
                                    </td>
                                    <td class="text-center" data-label="Amount">
                                        {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount ) }} - <span
                                            class="text-danger" title="@lang('charge')">{{
                                            showAmount($withdraw->charge)}} </span>
                                        <br>
                                        <strong title="@lang('Amount after charge')">
                                            {{ showAmount($withdraw->amount-$withdraw->charge) }} {{
                                            __($general->cur_text) }}
                                        </strong>

                                    </td>
                                    <td class="text-center" data-label="Conversion">
                                        1 {{ __($general->cur_text) }} = {{ showAmount($withdraw->rate) }} {{
                                        __($withdraw->currency) }}
                                        <br>
                                        <strong>{{ showAmount($withdraw->final_amount) }} {{ __($withdraw->currency)
                                            }}</strong>
                                    </td>
                                    <td class="text-center" data-label="Status">
                                        @php echo $withdraw->statusBadge @endphp
                                    </td>
                                    <td data-label="Action">
                                        <button class="btn btn--base btn--sm detailBtn "
                                            data-user_data="{{ json_encode($withdraw->withdraw_information) }}" 
                                            @if ($withdraw->status == 3)
                                            data-admin_feedback="{{ $withdraw->admin_feedback }}"
                                            @endif
                                            >
                                            <i class="la la-desktop"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%" data-label="No Data">{{ __($emptyMessage) }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if($withdraws->hasPages())
            <div class="d-flex justify-content-end mt-4 mb-2">
                {{$withdraws->links()}}
            </div>
            @endif
        </div>
    </div>
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
                <ul class="list-group userData">

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
            var userData = $(this).data('user_data');
            var html = ``;
            userData.forEach(element => {
                if (element.type != 'file') {
                    html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                }
            });
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