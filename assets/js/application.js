const addImgClass = () => {
    const image = $('img');
    image.addClass('img-fluid');
    image.removeAttr('style');
};

$(document).ready(() => {
    addImgClass();
});
