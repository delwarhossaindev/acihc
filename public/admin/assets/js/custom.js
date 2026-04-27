function selectPermission(param){ 
    $('input[id='+param+']').prop('checked', $('.'+param+'').prop('checked'));
}

$(document).ready(function () {
    $("#selectAll").click(function(){
    var clicks = $(this).data('clicks');
    $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    if (clicks) {
        $('#replace').html('Select All');
    } else {
        $('#replace').html('Reset All');
    }
        $(this).data("clicks", !clicks);
    });
});

//form validation
$(document).ready(function () {
  const forms = document.querySelectorAll('.needs-validation');
  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
});

//show confirmation before delete
$("body").on("click",".show_confirm",function(event){
  var form =  $(this).closest("form");
  event.preventDefault();
  swal({
      title: `Do you want to delete it?`,
      text: "If you delete this, it will be gone forever.",
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      form.submit();
    }
  });
});

//open dynamic modal
$('body').on('click', '.ajax-modal-btn', function(e) {
  e.preventDefault();
  var url = $(this).data('link');
  $.get(url, function(data) {
    $('#myDynamicModal').modal('show');
    $('#id').val(data.id);
    $('#name').val(data.name);
    $('#display_name').val(data.display_name);
    $('#description').val(data.description);
  })
});

//open dynamic modal
$('body').on('click', '.dynamic-edit-modal-btn', function(e) {
  
  
  e.preventDefault();
  var url = $(this).data('link');
  $.get(url, function(data) {
    $('.edit-modal').html(data)
    $('#myDynamicEditModal').modal('show');
  })
});

//open dynamic modal
$('body').on('click', '.dynamic-approval-modal-btn', function(e) {
  e.preventDefault();
  var url = $(this).data('link');
  $.get(url, function(data) {
    $('.approval-modal').html(data)
    $('#myDynamicEditModalaa').modal('show');
  })
});
