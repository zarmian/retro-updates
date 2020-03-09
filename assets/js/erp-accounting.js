(function($) {

    var isRequestDone = false;

    var ERP_Accounting = {

        initialize: function() {

            this.incrementField();

            // journal entry
            $('table.erp-ac-transaction-table.journal-table').on( 'click', '.remove-line', this.journal.onChange );
            $('table.erp-ac-transaction-table.journal-table').on( 'change', 'input.line_debit, input.line_credit', this.journal.onChange );

            $(document.body ).on( 'keyup change', '.line_price, .line_credit, .line_debit, .erp-ac-line-due, input.pay_amount', this.keyUpNumberFormating );

        },

        incrementField: function() {
            $( 'table.erp-ac-transaction-table' ).on( 'click', '.add-line', this.table.addRow );
            $( 'table.erp-ac-transaction-table' ).on( 'click', '.remove-line', this.table.removeRow );

            $( 'table.erp-ac-transaction-table.payment-voucher-table' ).on( 'click', '.remove-line', this.paymentVoucher.onChange );
            $( 'table.erp-ac-transaction-table.payment-voucher-table' ).on( 'change', 'input.line_qty, input.line_price, input.line_dis, input.discount', this.paymentVoucher.onChange );
            //$( 'table.erp-ac-transaction-table.payment-voucher-table' ).on( 'change', 'select.erp-ac-tax-dropdown', this.paymentVoucher.onChange );
        },


        /**
         * Table related general functions
         *
         * @type {Object}
         */
        table: {
            removeRow: function(e) {
                if ( typeof e !== 'undefined' ) {
                    e.preventDefault();
                }

                var self = $(this),
                    table = self.closest( 'table' );

                if ( table.find('tbody > tr').length < 2 ) {
                    return;
                }

                self.closest('tr').remove();
            },

            addRow: function(e) {
                e.preventDefault();

                var self = $(this),
                    table = self.closest( 'table' );

                // destroy the last select2 for proper cloning
                table.find('tbody > tr:first').find('select').not('select.erp-ac-tax-dropdown').select2('destroy');

                var tr = table.find('tbody > tr:first'),
                    clone = tr.clone();

                clone.find('input').val('');
                clone.find('input[name="line_qty[]"]').val(1);

                tr.after( clone );

                // re-initialize selec2
                //
                $('.erp-ac-transaction-form').find('.erp-ac-transaction-table .chosen').select2();
            }
        },

        /**
         * Payment voucher
         *
         * @type {Object}
         */
        paymentVoucher: {

            calculate: function() {


                var table = $('table.payment-voucher-table');
                var total = 0.00;
                var total_tax = [];

                var discount_amt   = ( table.find('input.discount').val() ) || '00';

                table.find('tbody > tr').each(function(index, el) {

                    if ( ! $(el).is(":visible") ) {
                        return;
                    }

                    var row        = $(el);
                    var qty        = ( row.find('input.line_qty').val() ) || 1;
                    var line_price = ( row.find('input.line_price').val() ) || '00'; //Unit Amount
                    var discount   = ( row.find('input.line_dis').val() ) || '00';
                    var tax_id     = row.find('select.line_tax').val();
                    var line_tax   = parseFloat('0.00');
                    var tax_amount = parseFloat('0.00');
                    var cal_dis_amount = 0;

                    qty        = ERP_Accounting.calNumNormal( qty );
                    line_price = ERP_Accounting.calNumNormal( line_price );
                    discount   = ERP_Accounting.calNumNormal( discount );


                    var price = parseFloat( qty ) * parseFloat( line_price );

                    if ( discount_amt > 0 ) {
                        cal_dis_amount =  ( parseFloat(line_price) * parseFloat(discount_amt) );
                    }

                    // if ( tax_id != '-1' ) {
                    //     var tax_info = erp_ac_tax.rate[tax_id];
                    //         line_tax =  parseFloat( tax_info.rate );

                    //     tax_amount = ( parseFloat( price ) * parseFloat( line_tax ) ) / 100;

                    // }

                    //var prev_tax = isNaN( total_tax[tax_id] ) ? parseFloat('0.00') : total_tax[tax_id];
                    //total_tax[tax_id] = prev_tax;

                    total += price;

                    row.find('input.line_total').val( ERP_Accounting.numFormating( total ) );// Amount

                    // row.find('input.line_total_disp').val( ERP_Accounting.numFormating( price ) );

                    var sub_total = total;

                    total = sub_total - parseFloat(cal_dis_amount);

                    table.find('tfoot input.sub-total').val( ERP_Accounting.numFormating( sub_total ) );


                    table.find('tfoot input.price-total').val( ERP_Accounting.numFormating( total ) );



                    //row.find('input.line_tax_amount').val( ERP_Accounting.numFormating( tax_amount ) );
                    // row.find('input.line_tax_rate').val( ERP_Accounting.numFormating( line_tax ) );

                });

                // var total_tax_amout = parseFloat( 0.00 );
                //
                // var tax_id     = table.find('select.vat_tax').val();
                //
                //
                // if ( tax_id != '-1' ) {
                //
                //
                //     var tax_info = table.find('select.vat_tax').find(':selected').data('rate');
                //     //alert(tax_info);
                //     //var tax_info = erp_ac_tax.rate[tax_id];
                //     vat_tax =  parseFloat(tax_info);
                //
                //     total_tax_amout = (parseFloat(total) * parseFloat(vat_tax)) / 100;
                //
                // }
                //
                // //alert(total_tax_amout);
                //
                // // $.each( total_tax, function( tax_id, tax_amounts ) {
                // //     if ( typeof tax_amounts != 'undefined' ) {
                // //         total_tax_amout = parseFloat( tax_amounts ) + total_tax_amout;
                // //         $('input[data-tax_id="'+tax_id+'"]').val( ERP_Accounting.numFormating( tax_amounts ) );
                // //     }
                // // });


            },

            onChange: function() {

                ERP_Accounting.paymentVoucher.calculate();
            },


        },

        /**
         * Journal entry
         *
         * @type {Object}
         */
        journal: {
            calculate: function() {


                var table = $('.journal-table');
                var debit_total = credit_total = 0;

                table.find('tbody > tr').each(function(index, el) {
                    var row    = $(el);
                    var debit  = ( row.find('input.line_debit').val() ) || '0';
                    var credit = ( row.find('input.line_credit').val() ) || '0';

                    var debit = ERP_Accounting.calNumNormal( debit );
                    var credit = ERP_Accounting.calNumNormal( credit );

                    // both are filled
                    if ( debit > 0 && credit > 0 ) {
                        debit = 0;
                        row.find('input.line_debit').val( ERP_Accounting.numFormating( 0 ) );
                    }

                    debit_total +=  parseFloat( debit );
                    credit_total += parseFloat( credit );
                });

                var diff = Math.abs( credit_total - debit_total );

                table.find('tfoot input.debit-price-total').val( ERP_Accounting.numFormating( debit_total ) );
                table.find('tfoot input.credit-price-total').val( ERP_Accounting.numFormating( credit_total ) );

                if ( diff !== 0 ) {
                    table.find('.erp-ac-journal-diff').removeClass('valid').addClass('invalid').val( ERP_Accounting.numFormating( diff ) );
                    $( '#submit_erp_ac_journal' ).attr('disabled', 'disabled');

                } else {
                    table.find('.erp-ac-journal-diff').removeClass('invalid').addClass('valid').val( ERP_Accounting.numFormating( diff ) );
                    $( '#submit_erp_ac_journal' ).removeAttr('disabled');
                }

            },

            onChange: function() {
                ERP_Accounting.journal.calculate();
            }
        },
        keyUpNumberFormating: function(e) {
            e.preventDefault();

            var self = $(this),
                current_value  = self.val(),
                prev_value     = self.data('value'),
                decimal_sep    = ERP_AC.decimal_separator,
                number_decimal = ERP_AC.number_decimal,
                decimal_count  = typeof current_value.split(decimal_sep)[1] == 'undefined' ? 0 : current_value.split(decimal_sep)[1];
            decimal_count  = decimal_count.length - 1;

            if ( decimal_count >= number_decimal ) {
                var split      = current_value.split(decimal_sep),
                    first_term = split.shift() + decimal_sep,
                    last_term  = split.join('').slice(0, number_decimal),
                    new_val    = first_term + last_term;
                self.val( new_val );
                ERP_Accounting.paymentVoucher.calculate();
                ERP_Accounting.journal.calculate();
            }

            var regex    = new RegExp( '[^\-0-9\%\\'+ERP_AC.decimal_separator+']+', 'gi' ),
                newvalue = current_value.replace( regex, '' );

            if ( current_value !== newvalue ) {
                self.val( newvalue );
            }
        },

        calNumNormal: function( $number ) {
            return $number.replace(",", ".");
        },
        numFormating: function( $number ) {
            var options = {
                symbol : ERP_AC.symbol,
                decimal : ERP_AC.decimal_separator,
                thousand: ERP_AC.thousand_separator,
                precision : ERP_AC.number_decimal,
                format: "%v" //with currency "%s%v"
            };

            return accounting.formatMoney( $number, options);
        },


    };


    $(function() {
        ERP_Accounting.initialize();

    });



})(jQuery);
