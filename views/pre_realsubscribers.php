 <!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">پیش ثبت نام مشترکین حفیفی</legend>
                    <div class="form-group row">
                        <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <label class="col-form-label col-lg-2" >انتخاب استان</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" required name="ostan_id" id="ostan_id">
                            </select>
                        </div>
                        
                        <label class="col-form-label col-lg-2">نام شهر</label>
                        <div class="col-lg-4">
                            <input type="text" id="name" class="form-control" required name="name" placeholder="مثال: تهران">
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_city" id="send_city" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
</div>
<!-- /content area -->




<!-- /main content -->