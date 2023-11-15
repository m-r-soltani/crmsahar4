<div class="content">
    <div class="card" id="online_user_tab">
        <div class="card-body">
            <form action="#" name="online_user_form_request">
                <fieldset class="mb-3">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">نوع سرویس</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom-select" name="service_type"
                                    id="online_user_service_type" required>
                                    <option disabled selected value> -- یک مورد را انتخاب کنید -- </option>
                                    <option value="adsl">ADSL</option>
                                    <option value="vdsl">VDSL</option>
                                    <option value="bitstream">Bitstream</option>
                                    <option value="wireless">Wireless</option>
                                    <option value="tdlte">Tdlte</option>
                                    <option value="voip">Voip</option>
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">انتخاب نام کاربری</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" name="ibsusername"
                                    id="online_user_select_username" required>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_ft_online_user" class="btn btn-primary">تایید<i
                            class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
            <div class="col-sm-12">
                <table id="online_user_table" class="table table-striped datatable-responsive table-hover">
                </table>
            </div>
        </div>
    </div>
</div>
