<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="#" name="connection_log_form_request">
                <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">گزارش Connection Log</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">انتخاب سرویس</label>
                            <div class="col-md-10">
                                <select class="form-control form-control-md custom_select" required name="service" id="service">
                                    <option value="" selected disabled>یک مورد را انتخاب کنید</option>
                                </select>
                            </div>
                        <label class="col-form-label col-md-2">نوع مصرف</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" name="noe_masraf"
                                    id="connection_log_noe_masraf" required>
                            </select>
                        </div>

                        <label class="col-form-label col-md-2">از تاریخ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control pwt-datepicker-input-element" name="time_from"
                                   id="connection_log_time_from" placeholder="مثال: 1380/05/20" required>
                        </div>
                        <label class="col-form-label col-md-2">تا تاریخ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control pwt-datepicker-input-element" name="time_to"
                                   id="connection_log_time_to" placeholder="مثال: 1380/05/20" required>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_ft_connection_log" id="send_ft_connection_log" class="btn btn-primary">تایید<i
                            class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
            <div class="col-sm-12">
                <table id="connection_log_table" class="table table-striped datatable-responsive table-hover">
                </table>
            </div>
        </div>
    </div>
</div>
