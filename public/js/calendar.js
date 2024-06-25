    $(function () {
      $('.cancel-modal-open').on('click', function() {
        $('.js-modal').fadeIn();
        var day = $(this).attr('day');
        var part = $(this).attr('part');
        $('.modal-body-day input').val(day);
        $('.modal-body-part input').val(part);
        $('.modal-body-day hidden').val(day);
        $('.modal-body-part hidden').val(part);
        return false;
      });
      $('.js-modal-close').on('click', function () {
        $('.js-modal').fadeOut();
        return false;
      });
      
    });
