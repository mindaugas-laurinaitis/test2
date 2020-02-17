// app.js
require('../css/app.scss');
const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

const app = {
    init: function () {
        $(() => {
            this.sortableTable();
        });
    },
    sortableTable: function () {
        $('.sortable-table .sortable').each(function () {
            let $this = $(this);
            $this.on('click', function () {
                let order = 'asc';
                if($this.hasClass('asc')) {
                    order = 'desc';
                }
                if($this.hasClass('desc')) {
                    order = null;
                }
                $this.removeClass('asc').removeClass('desc').addClass(order);

                $.get(
                    '/admin/subscriber/list',
                    order !== null ? 'order[' + $this.data('field-name') + ']=' + order : '',
                    data => {
                        console.log($this);
                        console.log($this.closest('tbody'));
                        $this.parents('table').find('tbody').html(data);
                    }
                );
            });
        });
    }
};

app.init();