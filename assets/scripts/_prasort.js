$('.prasort').on('change', function (e) {
    const urlParams = new URLSearchParams(window.location.search);
    $this = $(this);

    if ($this.val() !== 'none') {
        urlParams.set('orderby', $this.val());
    } else {
        urlParams.delete('orderby');
    }
    window.location.search = urlParams;
});

