var confirmNotice = (noticeName) => {
    let itemId = Cookies.get(`${noticeName}_notice`);
    if (itemId === 'true') {
        $(`div[data-notice="${noticeName}"]`)
            .removeClass(`alert alert-primary`)
            .html(``);
    }
}
var hideNotice = (noticeName) => {
    let itemId = Cookies.get(`${noticeName}_notice`);
    if (itemId == undefined) {
        Cookies.set(`${noticeName}_notice`, 'true');
    }
    $(`div[data-notice="${noticeName}"]`).html(``);
}
$(`span[data-notice="dashboard"]`).on('click', function() {
    hideNotice('dashboard');
});