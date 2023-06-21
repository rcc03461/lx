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
    <div class="flex flex-shrink-0 items-end gap-4">
        <div class="form-group">
            <label for="search_type">Type</label>
            <select class="form-control" name="search_type" id="">
                <option value="gp">GP Report</option>
            </select>
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
                    // $('datatable').dataTable();
                }
            });
        });
    });
</script>
