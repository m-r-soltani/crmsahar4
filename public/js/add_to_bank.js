$(document).ready(function () {
  file_id = $("#file_id");
  bank_id = $("#bank_id");
  Initialize("add_to_bank_banklist", function (data) {
    console.log(data);
    for (let i = 0; i < data.length; i++) {
      bank_id.append(
        "<option value=" + data[i].id + ">" + data[i].name + "</option>"
      );
    }
  });
  Initialize("add_to_bank_filelist", function (data) {
    console.log(data);
    for (let i = 0; i < data.length; i++) {
      file_id.append(
        "<option value=" +
          data[i].id +
          ">" +
          data[i].file_subject +
          " (" +
          data[i].file_name +
          ")" +
          "</option>"
      );
    }
  });
  var cols = [{
    "data": "id",
    title: 'شناسه',
},
    {
        "data": "name",
        title: 'نام بانک',
    },
    {
        "data": "filename",
        title: 'نام فایل'
    }
];

DataTable3('#view_table', /*path*/ 'add_to_bank', /*request(dont change)*/ 'datatable_request', /*request2*/ 'add_to_bank', 'POST', cols, function(table) {
    /*===================++  hide first column ++=========================*/
    //table.column(0).visible(false);
    /*===================++  select table row ++=========================*/
    $('#view_table tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    //onclick log row data
    /*$('#view_table tbody').on( 'click', 'tr', function () {
        console.log( table.row( this ).data() );
    } );*/
    $('#delete').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Hard_Delete(td, 'add_to_bank', function(data) {
            if (data) {
                table.ajax.reload();
            } else {
                alert('عملیات ناموفق');
            }
        });
    });
});
$('#edit').click(function() {
    let tr = $('#view_table tbody').find('tr.selected');
    let td = tr.find('td:first').text();
    Edit_Form('add_to_bank', td, function(data) {
        if (data) {
            $('#id').val(data[0]['id']);
            $('#name').val(data[0]['name']);
            $('#ostan_id option[value="' + data[0]['ostan_id'] + '"]').attr('selected', 'selected');
        } else {
            alert('مشکل در انجام درخواست لطفا مجددا تلاش کنید.');
        }


        //$('.form-group').each(function(i) {

        //});

    });
});


});