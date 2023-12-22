        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card container">
                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset class="mb-3">
                        <div class="form-group row">
                        <legend class="text-uppercase font-size-lg font-weight-bold center" style="color: #FB8C00">امکان سنجی ارائه سرویس</legend>
                                <label class="col-form-label col-lg-2">نوع سرویس <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="noe_service" id="noe_service" required>
                                        <option value="1">ADSL</option>
                                        <option value="2">VDSL</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">بررسی دایری از دیگر شرکت ها <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="baresie_dayeri" id="baresie_dayeri" required>
                                        <option value="1">بله</option>
                                        <option value="2">خیر</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">تلفن <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" pattern="^0\d{2,3}\d{8}$" name="telephone" id="telephone" placeholder="مثال: 02122376081" required>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_pre_asiatech_bitstream_emkansanji" class="btn btn-primary" onsubmit="resetId()">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form inputs -->
        </div>
        <!-- /content area -->