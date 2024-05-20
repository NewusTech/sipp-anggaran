jQuery(function ($) {
    var mediaArray = [];
    var selectedMediasId;
    var isMultipleAllowed = true;
    $('#allowmultiple').click(function () {
        isMultipleAllowed = $('#allowmultiple').is(':checked') ? true : false;
        $('.image-checkbox-checked').each(function () {
            $(this).removeClass('image-checkbox-checked');
        });
        mediaArray = [];
        $('#selectedmediapreview').html('');
    });

    $(".image-checkbox").on("click", function (e) {
        var selected = $(this).find('img').attr('data-path');
        //console.log(selected);
        if ($(this).hasClass('image-checkbox-checked')) {
            $(this).removeClass('image-checkbox-checked');
            // remove deselected item from array
            mediaArray = $.grep(mediaArray, function (value) {
                return value != selected;
            });
        }
        else {
            if (isMultipleAllowed == false) {
                $('.image-checkbox-checked').each(function () {
                    $(this).removeClass('image-checkbox-checked');
                });
                mediaArray = [];
                mediaArray.push(selected);
            } else {
                if (mediaArray.indexOf(selected) === -1) {
                    mediaArray.push(selected);
                }
            }
            $(this).addClass('image-checkbox-checked');
        }
        //console.log(selected);
        //console.log(mediaArray);
        selectedMediasId = mediaArray.join(",");
        //console.log(selectedMediasId);
        $('#selectedmediapreview').html('<div class="alert alert-success"><pre lang="js">' + JSON.stringify(mediaArray.join(", "), null, 4) + '</pre></div>');
        //console.log(isMultipleAllowed);
        e.preventDefault();
    });

    $('.show-file').on('click', function() {
        mediaArray = [];
        $('.check-all-'+$(this).data('id')).removeClass('image-checkbox-checked');
        $('.row-file').hide();
        $('.file-preview-'+$(this).data('id')).show();
        var elems = $('.files-list-'+$(this).data('id'));

        $('.check-all-'+$(this).data('id')).addClass('image-checkbox-checked');

        for (var i=elems.length; i--;) mediaArray.push(elems[i].dataset.path);

    });

    $('#downloadFiles').on('click', function(e) {

        e.preventDefault();

        var temporaryDownloadLink = document.createElement("a");
        temporaryDownloadLink.style.display = 'none';

        document.body.appendChild(temporaryDownloadLink);

        for( var n = 0; n < mediaArray.length; n++ )
        {
            var download = mediaArray[n];
            temporaryDownloadLink.setAttribute( 'href', download);
            temporaryDownloadLink.setAttribute( 'download', download.split('/').pop());

            temporaryDownloadLink.click();
        }

        document.body.removeChild( temporaryDownloadLink );
    });
});
