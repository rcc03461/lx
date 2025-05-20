<section>
    <div class="flex flex-shrink-0 items-end gap-4">
        <div class="form-group">
            <label for="date_form">From</label>
            {{-- default month start --}}
            <input class="form-control" type="date" name="date_from" value="{{ date('Y-m-01') }}" id="">
        </div>
        <div class="form-group">
            <label for="date_to">To</label>
            {{-- default month end --}}
            <input class="form-control" type="date" name="date_to" value="{{ date('Y-m-t') }}" id="">
        </div>
        <div class="form-group">
            <button class="btn btn-primary search">Search</button>
        </div>
        <div class="form-group">
            <button class="btn export_xero_cre8">Export to Xero (Cre8)</button>
            <button class="btn export_xero_lx">Export to Xero (Lx)</button>
        </div>
    </div>
    <div class="flex flex-shrink-0 items-end gap-4 justify-between">
        <div class="form-group">
            <label for="search_type">Type</label>
            <select class="form-control" name="search_type" id="">
                <option value="gp">GP Report</option>
            </select>
        </div>
        <div id="update-settlement-date" class="flex gap-4">
            <div class="form-group">
                {{-- <label for="settlement_date">settlement_date</label> --}}
                {{-- default month end --}}
                <input class="form-control" type="date" name="settlement_date" value="{{ date('Y-m-d') }}" id="">
            </div>
            <div class="form-group">
                {{-- <label for="">&nbsp;</label> --}}
                <button class="btn set-settlment-date">Set Selected Settlement Date </button>
            </div>
        </div>
    </div>
    <div class="text-center text-lg font-bold sticky z-10 top-20 bg-white py-2 border shadow-md my-2">
        Selected Total: <span id="selected-total" class="w-24"></span>
    </div>
    <div id="loaded-content"></div>
</section>
<style>
    #loaded-content tr:nth-child(3n + 1) {
        background-color: #cfcfcf;
    }
    #loaded-content tr:hover {
        background-color: #c9c9c9;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function(){

        loadPresetDate();

        function loadPresetDate() {
            const date_from = localStorage.getItem('date_from');
            const date_to = localStorage.getItem('date_to');
            const search_type = localStorage.getItem('search_type');

            if (date_from && date_to && search_type) {
                search()
            }
        }

        function search() {
            const date_from = $('input[name="date_from"]').val();
            const date_to = $('input[name="date_to"]').val();
            const search_type = $('select[name="search_type"]').val();

            localStorage.setItem('date_from', date_from);
            localStorage.setItem('date_to', date_to);
            localStorage.setItem('search_type', search_type);

            $.ajax({
                url: `account/report/${search_type}`,
                type: "GET",
                data: {
                    date_from: `${date_from} 00:00:00`,
                    date_to: `${date_to} 23:59:59`,
                    search_type: search_type
                },
                success: function(data){
                    $('#loaded-content').html("");
                    // table.destroy();
                    $(`<table id="datatable" ></table>`).appendTo('#loaded-content');
                    const table = new DataTable('#datatable', {
                        lengthMenu: [[-1], ["All"]],
                        data: data.data,
                        columns: data.columns,
                        width: '100%',
                        select: true,
                        createdRow( row, data, dataIndex ) {
                            // console.log(row, data, dataIndex);
                            // console.log(row);
                            // $(row).addClass('bg-blue-500');
                        }
                    });

                    table.on('click', 'tbody tr', (e) => {
                        console.log(e.currentTarget, 'clicked');
                        let classList = e.currentTarget.classList;

                        if (classList.contains('selected')) {
                            $(e.currentTarget).removeClass('selected bg-blue-500');
                        }
                        else {
                            $(e.currentTarget).addClass('selected bg-blue-500');
                        }

                        // selected-total
                        const selected = $('#datatable').DataTable().rows('.selected').data();
                        const total = selected.reduce((acc, item) => {
                            // 18,738.00 => 18738.00
                            const amount = parseFloat(item.total.replace(/,/g, ''));
                            return acc + amount;
                        }, 0);
                        // format to 18,738.00
                        $('#selected-total').html(total.toLocaleString('en-US', {minimumFractionDigits: 2}));
                    });


                    // Add event listener for opening and closing details
                    // table.on('click', 'td.dt-control', function (e) {
                    //     let tr = e.target.closest('tr');
                    //     let row = table.row(tr);
                    //     // console.log(table, tr, 'clicked');

                    //     if (row.child.isShown()) {
                    //         // This row is already open - close it
                    //         row.child.hide();
                    //     }
                    //     else {
                    //         // Open this row
                    //         row.child("format(row.data())").show();
                    //     }
                    // });



                    // $('datatable').dataTable();
                }
            });
        }

        $('.search').click(search);

        $('.export_xero_cre8').on('click', function(){
            const date_from = $('input[name="date_from"]').val();
            const date_to = $('input[name="date_to"]').val();
            const search_type = $('select[name="search_type"]').val();

            window.open('account/export_xero_cre8?date_from='+date_from+'&date_to='+date_to+'&search_type='+search_type, '_blank');
        })
        $('.export_xero_lx').on('click', function(){
            const date_from = $('input[name="date_from"]').val();
            const date_to = $('input[name="date_to"]').val();
            const search_type = $('select[name="search_type"]').val();

            window.open('account/export_xero_lx?date_from='+date_from+'&date_to='+date_to+'&search_type='+search_type, '_blank');
        })

        // set settlement date
        $('.set-settlment-date').on('click', function(){
            const settlement_date = $('input[name="settlement_date"]').val();
            const selected = $('#datatable').DataTable().rows('.selected').data();
            // console.log(selected);
            const ids = selected.map((item) => item.id);
            console.log(ids.toArray(), settlement_date);

            $.ajax({
                url: `api/account/update_settlements`,
                type: "POST",
                data: {
                    settlement_date: settlement_date,
                    ids: ids.toArray()
                },
                success: function(data){

                    $('.search').click();
                }
            });
        });

    });
</script>
