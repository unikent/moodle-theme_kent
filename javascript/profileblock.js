function theme_kent_toggle_block(showHideDiv, switchImgTag) {
    var ele = document.getElementById(showHideDiv);
    var imageEle = document.getElementById(switchImgTag);

    if (ele.style.display == "block") {
        ele.style.display = "none";
        imageEle.className = 'down';
    } else {
        ele.style.display = "block";
        imageEle.className = 'up';
    }
}