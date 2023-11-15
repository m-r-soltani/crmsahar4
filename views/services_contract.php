<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST" name="services_contract_form">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">قرار دادها</legend>
                    <div class="form-group row">
                        <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <label class="col-form-label col-lg-2">انتخاب نوع سرویس</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" required name="service_type"
                                id="service_type">

                            </select>
                        </div>
                        <div class="col-lg-6">
                        </div>
                        <label class="col-form-label col-lg-2">عنوان قرار داد</label>
                        <div class="col-lg-10">
                            <input type="text"  class="form-control" required name="contract_subject" id="contract_subject" placeholder="">
                        </div>
                        
                        <label class="col-form-label col-lg-2">انتخاب قرارداد </label>
                        <div class="col-lg-10">
                            <textarea type="" class="form-control elastic" required id="contract_content" name="contract_content" > </textarea>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_services_contract" id="send_services_contract" class="btn btn-primary">ارسال <i
                            class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
    <div class="card">
        <div class="col-md-12">
            <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
            <table id="view_table" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div>
</div>
<!-- /content area -->




<!-- /main content -->