/*
 * @package YITH WooCommerce Dynamic Pricing and Discounts Premium
 * @since   1.1.7
 * @author  YITH
 */

jQuery(function ($) {
  "use strict";

  var default_price_html = $(ywdpd_qty_args.column_product_info_class).find(ywdpd_qty_args.product_price_classes).html(),
    select_default_qty = function () {

      if ('yes' == ywdpd_qty_args.is_default_qty_enabled) {
        var table = $(document).find('#ywdpd-table-discounts'),
          td = false;

        if (ywdpd_qty_args.show_minimum_price === 'yes') {

          td = table.find('td.qty-price-info').last();
        } else {
          td = table.find('td.qty-price-info').first();
        }

        td.click();
      }
    },
    select_right_price_info = function ($t) {
      var span_price_html = $t.html(),
        qty = ($t.data('qtymax') != '*') ? $t.data('qtymax') : $t.data('qtymin'),
        qty_field = $t.closest(ywdpd_qty_args.column_product_info_class).find(ywdpd_qty_args.product_qty_classes),
        price = $t.closest(ywdpd_qty_args.column_product_info_class).find(ywdpd_qty_args.product_price_classes),
        sale_price = price.find('del').length ? price.find('del').html() : '',
        index = $t.index(),
        td_price_info = false;

      $('td').removeClass('ywdpd_qty_active');
      if (ywdpd_qty_args.template === 'horizontal') {
        td_price_info = $(document).find('#ywdpd-table-discounts td.qty-info').get(index - 1);
        td_price_info = $(td_price_info);
      } else {

        td_price_info = $t.parent().find('td.qty-info');
      }

      $t.addClass('ywdpd_qty_active');

      if (td_price_info) {
        $(td_price_info).addClass('ywdpd_qty_active');
      }

      qty_field.val(qty);
      price.html('<del>' + sale_price + '</del> ' + span_price_html);
    },
    select_right_qty_info = function ($t) {
      var index = $t.index();
      $('td.qty-info').removeClass('ywdpd_qty_active');
      $t.addClass('ywdpd_qty_active');

      var td_price_info = false;

      if (ywdpd_qty_args.template === 'horizontal') {
        td_price_info = $(document).find('#ywdpd-table-discounts td.qty-price-info').get(index - 1);

        td_price_info = $(td_price_info);
      } else {
        td_price_info = $t.parent().find('td.qty-price-info')
      }
      if (td_price_info) {
        select_right_price_info(td_price_info);
      }

    };

  $(document).on('click', '#ywdpd-table-discounts td.qty-price-info', function (e) {
    var $t = $(this);
    select_right_price_info($t);
  });
  $(document).on('click', '#ywdpd-table-discounts td.qty-info', function (e) {

    var $t = $(this);
    select_right_qty_info($t);
  });
  $(document).on('change', 'form.cart .qty', function (e) {

    if ($(document).find('#ywdpd-table-discounts').length && 'yes' == ywdpd_qty_args.is_change_qty_enabled) {
      var qty = $(this).val(),
        td_qty_range_info = false,
        td_price_info = false;

      $('#ywdpd-table-discounts td.qty-info').removeClass('ywdpd_qty_active');
      $('#ywdpd-table-discounts td.qty-price-info').removeClass('ywdpd_qty_active');

      if (ywdpd_qty_args.template === 'horizontal') {
        td_qty_range_info = $('#ywdpd-table-discounts').find('td.qty-info').filter(function () {
          var max = $(this).data('qtymax');
          if (max !== '*') {
            return $(this).data('qtymin') <= qty && $(this).data('qtymax') >= qty;
          } else {
            return $(this).data('qtymin') <= qty;
          }
        });
        if (td_qty_range_info.length) {
          var index = td_qty_range_info.index(),
            td_price_info = $('#ywdpd-table-discounts td.qty-price-info').get(index - 1);
          td_price_info = $(td_price_info);
        } else {
          td_qty_range_info = false;
        }
      } else {
        td_price_info = $('#ywdpd-table-discounts').find('td.qty-price-info').filter(function () {
          var max = $(this).data('qtymax');
          if (max !== '*') {
            return $(this).data('qtymin') <= qty && $(this).data('qtymax') >= qty;
          } else {
            return $(this).data('qtymin') <= qty;
          }
        });

        if( td_price_info.length) {
          td_qty_range_info = td_price_info.parent().find('td.qty-info');
        }else{
          td_qty_range_info = false;
        }
      }

      if (td_qty_range_info) {
        td_qty_range_info.addClass('ywdpd_qty_active');
        td_price_info.addClass('ywdpd_qty_active');

        var price = td_price_info.closest(ywdpd_qty_args.column_product_info_class).find(ywdpd_qty_args.product_price_classes),
          sale_price = price.find('del').length ? price.find('del').html() : '',
          span_price_html = td_price_info.html();

        price.html('<del>' + sale_price + '</del> ' + span_price_html);
      } else {
        $('ywdpd-table-discounts').find('tr,td').removeClass('ywdpd_qty_active');
       $(ywdpd_qty_args.column_product_info_class).find(ywdpd_qty_args.product_price_classes).html(default_price_html);
      }
    }
  });


  var $product_id = $('[name|="product_id"]'),
    product_id = $product_id.val(),
    $variation_id = $('[name|="variation_id"]'),
    form = $product_id.closest('form'),
    $table = $('.ywdpd-table-discounts-wrapper');

  $(document).on('found_variation', form, function (event, variation) {
    $('.ywdpd-table-discounts-wrapper').replaceWith(variation.table_price);
    select_default_qty();
  });

  if (!$variation_id.length) {
    select_default_qty();
    return false;
  }

  $variation_id.on('change', function () {
    if ($(this).val() == '') {
      $('.ywdpd-table-discounts-wrapper').replaceWith($table);
    }
  });


});
