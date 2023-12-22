<!-- Footer -->
<div class="navbar navbar-expand-lg navbar-light">

    <div class="navbar-collapse collapse" id="navbar-footer">
		<span class="navbar-text" style="text-align: center;margin:auto">
            شبکه سحر ارتباط
			&copy; 2019 - <?php echo date('Y')?>
		</span>
    </div>
</div>
<!-- /footer -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->
</body>
</html>
<!-- Core JS files -->
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/main/jquery.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/main/bootstrap.bundle.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/loaders/blockui.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/datatables.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/extensions/responsive.min.js' ?>"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/forms/styling/uniform.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/pickers/color/spectrum.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/visualization/d3/d3.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/visualization/d3/d3_tooltip.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/ui/moment/moment.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/pickers/daterangepicker.js' ?>"></script>
<!--<script type="application/javascript" src="<?php /*echo __ROOT__ . '/public/js/plugins/forms/styling/switchery.min.js'*/ ?>"></script>-->
<!--<script type="application/javascript" src="<?php /*echo __ROOT__ . '/public/js/plugins/forms/styling/switch.min.js' */ ?>"></script>-->
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/forms/selects/select2.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/extensions/select.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/extensions/buttons.min.js' ?>"></script>

<!--<script src="<?php /*echo __ROOT__ . '/public/js/plugins/editors/datatable/dataTables.altEditor.js' */ ?>"></script>-->
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/app.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/demo_pages/picker_color.js' ?>"></script>

<!--<script src="<?php /*echo __ROOT__ . '/public/js/demo_pages/form_checkboxes_radios.js' */ ?>"></script>-->
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/demo_pages/form_inputs.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/persian-date.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/persian-datepicker.min.js' ?>"></script>
<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/validation-power.js' ?>"></script>


<script type="application/javascript" src="<?php echo __ROOT__ . '/public/js/functions.js' ?>"></script>

<?php
if (isset($this->js1)) {
    echo "<script src=' " . __ROOT__ . $this->js1 . "' type='application/javascript'></script>";
}
if (isset($this->js2)) {
    echo "<script src='" . __ROOT__ . $this->js2 . "' type='application/javascript'></script>";
}
if (isset($this->js3)) {
    echo "<script src='" . __ROOT__ . $this->js3 . "' type='application/javascript'></script>";
}
if (isset($this->js4)) {
    echo "<script src='" . __ROOT__ . $this->js4 . "' type='application/javascript'></script>";
}
if (isset($this->js5)) {
    echo "<script src='" . __ROOT__ . $this->js5 . "' type='application/javascript'></script>";
}
if (isset($this->js6)) {
    echo "<script src='" . __ROOT__ . $this->js6 . "' type='application/javascript'></script>";
}
if (isset($this->js7)) {
    echo "<script src='" . __ROOT__ . $this->js7 . "' type='application/javascript'></script>";
}
if (isset($this->js8)) {
    echo "<script src='" . __ROOT__ . $this->js8 . "' type='application/javascript'></script>";
}
if (isset($this->js9)) {
    echo "<script src='" . __ROOT__ . $this->js9 . "' ></script>";
}
?>


<!-- /theme JS files -->