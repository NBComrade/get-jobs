require('../css/main.scss');
require('../../../node_modules/bootstrap/dist/css/bootstrap.min.css');
require('../../../node_modules/bootstrap/dist/js/bootstrap.min.js');

var jobs = {
    addToFavorite: function(event) {
        var favoriteJob = $(event.target).closest(".single-job");
        var data = {
            title : favoriteJob.find('.job-link').text(),
            link : favoriteJob.find('.job-link').attr("href"),
            company : favoriteJob.find('.job-company-title').text(),
            date : favoriteJob.find('.job-date').text(),
            img: favoriteJob.find('.job-image').attr('src')
        }
        sendAjaxRequest('/add-favorite', data)
    }
}

function sendAjaxRequest(url, data, onSuccess, onError){
    $.ajax({
        url: 'http://get-jobs:81' + url,
        type: "POST",
        dataType: "json",
        data: JSON.stringify(data),
        async: true,
        success: onSuccess,
        error: onError
    });
    return false;

}
$(document).on('click', 'button.add-favorite', function (event) {
    jobs.addToFavorite(event);
});