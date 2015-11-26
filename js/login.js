/*global $, jQuery, tab:true, tab_content:true*/

jQuery(document).ready(function ($) {
    "use strict";
    tab = $('.tabs h3 a');
    tab.on('click', function (event) {
        event.preventDefault();
        tab.removeClass('active');
        $(this).addClass('active');
        tab_content = $(this).attr('href');
        $('div[id$="tab-content"]').removeClass('active');
        $(tab_content).addClass('active');
    });
});
