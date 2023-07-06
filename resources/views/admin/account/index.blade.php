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
            <button class="btn search">Search</button>
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
                <button class="btn set-settlment-date">Set Selected</button>
            </div>
        </div>
    </div>
    <div id="loaded-content">

    </div>
</section>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function(){
        $('.search').click(function(){
            const date_from = $('input[name="date_from"]').val();
            const date_to = $('input[name="date_to"]').val();
            const search_type = $('select[name="search_type"]').val();
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
                    const table = $(`<table id="datatable" ></table>`).appendTo('#loaded-content');
                    table.dataTable({
                        lengthMenu: [[-1], ["All"]],
                        data: data.data,
                        columns: data.columns
                    });
                    table.on('click', 'tbody tr', (e) => {
                        console.log(e.currentTarget, 'clicked');
                        let classList = e.currentTarget.classList;

                        if (classList.contains('selected')) {
                            $(e.currentTarget).removeClass('selected bg-blue-500');
                            // classList.remove('selected bg-blue-500');
                        }
                        else {
                            // table.rows('.selected').nodes().each((row) => row.classList.remove('selected'));
                            $(e.currentTarget).addClass('selected bg-blue-500');
                            // classList.add('selected bg-blue-500');

                        }
                    });
                    // $('datatable').dataTable();
                }
            });
        });

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
