<div class="content">

    <div class="card" id="online_user_tab">
        <div class="card-body">
            <form action="#" name="online_user_form_request">
                <fieldset class="mb-3">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">نوع سرویس</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom-select" name="servicetype"
                                    id="online_user_service_type" required>
                                    <option disabled selected value> -- یک مورد را انتخاب کنید -- </option>
                                    <option value="internet">Internet</option>
                                    <option value="voip">Voip</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_administration_online_report" class="btn btn-primary">تایید<i
                            class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
            <div class="col-sm-12" id = 'reporttab'>
                
                <table id="online_user_table" class="table table-striped datatable-responsive table-hover">
                </table>
            </div>
        </div>
    </div>
</div>
