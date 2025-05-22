import $ from "jquery";
import DataTable from 'datatables.net-dt';
import language from "datatables.net-plugins/i18n/ru.mjs";

$(document).ready(function() {
    new DataTable('#table', {
        paging: false,
        searching: true,
        ordering: true,
        info:false,
        language
    });
});
