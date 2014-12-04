function theme_kent_toggle_block(showHideDiv, switchImgTag, chevronTag) {
    var ele = document.getElementById(showHideDiv);
    var imageEle = document.getElementById(switchImgTag);
    var chevronTag = document.getElementById(chevronTag);

    if (ele.style.display == "block") {
        ele.style.display = "none";
        imageEle.className = 'down';
        chevronTag.className = 'fa fa-chevron-down';
    } else {
        ele.style.display = "block";
        imageEle.className = 'up';
        chevronTag.className = 'fa fa-chevron-up';
    }
}