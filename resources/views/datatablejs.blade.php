<script src="{{ mix('js/plugins.js') }}"></script>
<script>
    $(function() {
        var dTable = $('#{{ $datatableid }}')
        .DataTable({
            serverSide:         true,
            searchHighlight:    true,
            responsive:         true,
            stateSave:          true,
            paging:             true,
            lengthChange:       true,
            searching:          true,
            ordering:           true,
            info:               true,
            autoWidth:          false,
            processing:         true,
            language:   {
                loadingRecords: '&nbsp;',
                processing:     '<div class="spinner"></div>'
            },
            ajax: {
                url:    '{{ $datatableroute  }}',
                data:   function ( d ) {
                    var datatable = $('#{{ $datatableid }}').DataTable();
                    var info = datatable.page.info();
                    var dir = '';
                    var sortField = '';
                    var i = 0;
                    var firstSort = true;
                    var sortMultiple = '';
                    var firstMultiple = true;
                    var sortMultipleDir = '';
                    while (d.order[i]) {
                        if (firstSort) {
                            sortField = d.columns[d.order[i].column].data;
                            firstSort = false;
                            dir = d.order[i].dir;
                        } else {
                            if (firstMultiple) {
                                {{--  sortMultiple = sortField + ';' + d.columns[d.order[i].column].data;
                                sortMultipleDir = dir + ';' + d.order[i].dir;  --}}
                                sortMultiple = d.columns[d.order[i].column].data; 
                                sortMultipleDir = d.order[i].dir;
                                firstMultiple = false;
                            } else {
                                sortMultiple = sortMultiple + ';' + d.columns[d.order[i].column].data;
                                sortMultipleDir = sortMultipleDir + ';' + d.order[i].dir;
                            }
                            d.orderByMulti = sortMultiple;
                            d.sortedByMulti = sortMultipleDir;
                        }
                        i++;
                    }
                    d.with = '{{ $datatablewith }}';
                    d.searchText = d.search.value;
                    d.orderBy = sortField;
                    d.sortedBy = dir;
                    d.page = info.page + 1;
                    d.route = function () {
                        var url = window.location;
                        var a = $('<a>', { href:url })[0];
                            return a.search.split('=')[1];
                        };
                    },
                    dataFilter: function(data){
                        var json = jQuery.parseJSON( data );
                        json.recordsTotal = json.data.total;
                        json.recordsFiltered = json.data.total;
                        json.data = json.data.data;
                        return JSON.stringify( json ); // return JSON string
                    }
                }, //ajax
                columnDefs: [
                {
                    targets:  {{ $ellipsiscol }},
                    render:   Ellipsis(25, true)
                },
                {{ $slot }}
                ],
                columns:    [
                {{ $columns }}
                ],
                order:      [],
                dom:        'B<"toolbar">frtpil',
                buttons:    [
                'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                initComplete:   function() {
                    var $searchInput = $('div.dataTables_filter input');
                    $searchInput.unbind();
                    $searchInput.bind('keyup', function(e) {
                        if(e.keyCode == 13) {
                            dTable.search( this.value ).draw();
                        }
                    });
                }
            });

            $("div.toolbar").html(`
            <button id="btnRefresh" type="button" class="btn btn-sm btn-flat bg-gray pull-right" title="Refresh" style="margin-left: 6px;"><i class="fa fa-refresh"></i></button>
            `);

            $('#btnRefresh').on('click', function () {
                dTable.ajax.reload();
            });
        });
    </script>
