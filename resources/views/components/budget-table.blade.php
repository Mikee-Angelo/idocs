<table class="min-w-full leading-normal budget-sources-table">
    <thead>
        <tr>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Source Name
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Created At
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<script type="text/javascript">
    $(function () {

        var table = $('.budget-sources-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('budget-sources.index') }}",
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

        $(".budget-sources-table").on('click', '.del-btn[data-remote]', function (e) {
            e.preventDefault();

            var url = $(this).data('remote');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'budget-sources/' + url,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    method: '_DELETE',
                    submit: true
                }
            }).always(function (data) {
                $('.budget-sources-table').DataTable().draw(false);
            });
        });

    });

</script>