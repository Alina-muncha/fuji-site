<?php


echo '<div class="wrap">';
?>



<?php $key = 1; ?>
<div class="discountMessage notice notice-success is-dismissible" style="display: none;">
    <p>Discount rule updated.</p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text">
            Dismiss this notice.</span></button>
</div>
<h1 class="wp-heading-inline" style="display: none;">Fuji Discounts</h1>

<h1 class="wp-heading-inline">Fuji Discounts</h1>
<a href="#" data-toggle="modal" data-target="#exampleModal<?php echo esc_attr($key); ?>" class="page-title-action">
    Import
</a>
<p class="search-box">
    <label class="screen-reader-text" for="post-search-input">Search products:</label>
    <input type="search" id="discount_search" placeholder="Customer" value="">
    <input type="search" id="product_search" placeholder="Product SKU" value="">

</p>

<div id="result">
    <table id="job-alert-table" class="table w-100 wp-list-table widefat fixed striped table-view-list posts">

        <thead>
            <tr>
                <th><i class="far fa-bookmark mr-2 all"></i>Name</th>
                <th><i class="far fa-folder-open mr-2 all"></i>Email</th>
                <th><i class="far fa-map-marker-alt mr-2 all"></i>Product SKU</th>
                <th><i class="far fa-clipboard mr-2"></i>Product Name</th>
                <th><i class="far fa-clipboard-check mr-2"></i>Discount Type</th>
                <th class="drop-menu wwc-table-dd all">Discount</th>
            </tr>
        </thead>
        <tbody id="tableRow">
        </tbody>
    </table>
</div>


<div class="modal fade" id="exampleModal<?php echo esc_attr($key); ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload CSV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="ajax-loader ajax-modal-loader">
                <div class="loader modal-loader"></div>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="upload_form">

                    <input type="file" name="discountCSV" accept=".csv" />

                    <button type="submit " class="btn btn-primary install-plugin" style="float: right;">Upload</button>
                </form>
            </div>


        </div>

    </div>
</div>
<script>
// var $ = jQuery;
jQuery(document).ready(function($) {

    var discount = $('#job-alert-table').DataTable({
        "info": false,
        "dom": 'Rrtlip',
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            ['10/page', '20/page', '30/page', 'Show all']
        ],
        "language": {
            "paginate": {
                "next": ">",
                "previous": "<",
            }
        },
        "pageLength": 10,
        // "columnDefs": [{
        //     "targets": 5,
        //     "orderable": false
        // }]
    });

    $('#discount_search').on('keyup', function() {
        discount.columns(0).search(this.value).draw();
    });

    $('#product_search').on('keyup', function() {
        discount.columns(2).search(this.value).draw();
    });

    $('.notice-dismiss').click(function() {
        $('.discountMessage').hide();
    });

});
</script>
</div>