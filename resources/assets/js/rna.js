// Functions
function swalConfirmSubmit(button) {
    var confirmed = false;
    var text = button.data('text');

    button.on('click', function (e) {
        var target = e.target;

        if (!confirmed) {
            e.preventDefault();

            swal({
                title: 'Confirm Action',
                text: text,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#90a4ae',
                confirmButtonColor: '#5d6070',
                reverseButtons: true
            }).then(function (isConfirm) {
                if (isConfirm === true) {
                    confirmed = true;
                    target.click();
                }
            });
        }
    });
}

// Action confirmation
$('button[data-confirm]').each(function () {
    swalConfirmSubmit($(this));
});

// Editors
$('textarea').markdown({
    iconlibrary: 'fa'
});

// Material select inputs
$('select').material_select();

// Materialize modals
$('.modal-trigger').leanModal();

// Materialize sidenav
$('.button-collapse').sideNav({
    edge: 'right'
});

// Unslider
if ($('.slider').find('img').length > 1) {
    var slider = $('.slider').unslider({
        animation: 'fade'
    });
    $(window).on('load', function() {
        slider.height(slider.find('li:first img').height());
    });
    slider.on('unslider.change', function(event, index, slide) {
        slide.parents('.slider').height(slide.children('img').height());
    });
}

// Sortable
$('[data-sortable]').sortable({
    onDrop: function ($item, container, _super) {
        $('[data-sortable] li').each(function () {
            var parentId = 0;
            var parent = $(this).parent('ol').parent('li');

            if (parent.length) {
                var parentId = parent.data('id');
            }

            $(this).children('input[data-sorting]').val(parentId);
        });

        $('button[type="submit"][data-sortable-submit]').removeClass('disabled').prop('disabled', false);

        _super($item, container);
    }
});

// Datetime picker inputs
$('.datetimepicker').datetimepicker();

// Active navigation items
$('nav li a').not('.dropdown-button').each(function () {
    var href = this.pathname;
    if (href === window.location.pathname) {
        $(this).parent('li').addClass('active');
    }
});
