$('.prasort').on('change', function (e) {
    const urlParams = new URLSearchParams(window.location.search);
    $this = $(this);

    if ($this.val() !== 'none') {
        urlParams.set('rorderby', $this.val());
    } else {
        urlParams.delete('rorderby');
    }
    window.location.search = urlParams;
});

