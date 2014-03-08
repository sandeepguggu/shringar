<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2013-10-18 06:02:28 --> Severity: Notice  --> Undefined variable: params C:\xampp\shringar_live\application\controllers\rent.php 205
ERROR - 2013-10-18 06:02:31 --> Severity: Notice  --> Undefined variable: params C:\xampp\shringar_live\application\controllers\rent.php 205
ERROR - 2013-10-18 06:02:58 --> Severity: Notice  --> Undefined index: components C:\xampp\shringar_live\application\controllers\rent.php 312
ERROR - 2013-10-18 06:02:58 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\controllers\rent.php 312
ERROR - 2013-10-18 06:02:58 --> Severity: Notice  --> Undefined variable: components C:\xampp\shringar_live\application\controllers\rent.php 318
ERROR - 2013-10-18 06:02:58 --> Severity: Notice  --> Undefined index: components C:\xampp\shringar_live\application\controllers\rent.php 318
ERROR - 2013-10-18 06:03:32 --> Severity: Notice  --> Undefined index: pcomponent_price_39 C:\xampp\shringar_live\application\views\rent\pickupConfirmation.php 79
ERROR - 2013-10-18 06:03:32 --> Severity: Notice  --> Undefined variable: component C:\xampp\shringar_live\application\views\rent\pickupConfirmation.php 80
ERROR - 2013-10-18 11:52:59 --> Bill - Exchange BillArray
(
    [id] => 42
    [created_at] => 2012-08-26 19:35:50
    [user_id] => 3
    [paid_by_cash] => 199.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 25.20
    [vat_discount] => 0
    [total_amount] => 199.00
    [final_amount] => 199.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-10-18 11:52:59 --> Array
(
    [0] => Array
        (
            [price] => -99.00
            [name] => price
            [display_name] => MRP
            [id] => 9
            [level] => 1
            [sku] => 1
            [value] => 
        )

    [1] => Array
        (
            [mfg_barcode] => 8903380124675
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8903380124675
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 199.00
        )

)

ERROR - 2013-10-18 11:56:51 --> TOTAL BILL BACKEND855
ERROR - 2013-10-18 11:56:51 --> TOTAL BILL Frontend0
ERROR - 2013-10-18 11:56:52 --> Array
(
    [bill_id] => 43848
    [customer] => Array
        (
            [id] => 1
            [fname] => Walkin
            [lname] => 
            [dob] => 2012-08-22
            [sex] => 
            [phone] => 7411350398
            [email] => 
            [sms] => N
            [building] => 
            [street] => 
            [area] => 
            [city] => 
            [pin] => 
            [state] => 
            [user_id] => 3
            [loyalty_points] => 0
            [loyalty_points_valid_till] => 
        )

    [bill_subtotal] => 950
    [bill_amount] => 855
    [vat_amount] => 108.27510917031
    [discount] => 47.5
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 917
                    [row_count] => 1
                    [discount] => 10
                    [quantity] => 2
                    [price_initial] => 475.00
                    [discount_amount] => 47.5
                    [price_without_vat] => 373.36244541485
                    [vat_amount] => 108.27510917031
                    [attributes] => Array
                        (
                            [0] => Array
                                (
                                    [price] => -99.00
                                    [name] => price
                                    [display_name] => MRP
                                    [id] => 9
                                    [level] => 1
                                    [sku] => 1
                                    [value] => 
                                )

                            [1] => Array
                                (
                                    [mfg_barcode] => 041554275704
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 041554275704
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 475.00
                                )

                        )

                    [id] => 917
                    [header_id] => 3531
                    [price] => 475.00
                    [name] => Maybelline Dream Lumi Touch Concealer 340 
                    [desc_id] => 3321
                    [description] => 
                    [brand_id] => 5
                    [brand] => MAYBELLINE
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 161
                    [class] => Concealer
                    [details] => []
                    [header_mfg_barcode] => 041554275704
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 427.5
                    [stock] => 5.000
                    [mrp_value] => 2375.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 855
                )

        )

    [payment] => Array
        (
            [cash] => 855.00
            [card] => 0
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 855.00
                )

        )

    [status] => paid
    [date] => 18-10-2013
    [barcode] => 4060043848
    [print] => 0
)

ERROR - 2013-10-18 11:59:56 --> Severity: Notice  --> Undefined index: pcomponent_price_ C:\xampp\shringar_live\application\views\rent\invoiceConfirmation.php 79
ERROR - 2013-10-18 11:59:56 --> Severity: Notice  --> Undefined variable: component C:\xampp\shringar_live\application\views\rent\invoiceConfirmation.php 80
ERROR - 2013-10-18 12:00:02 --> Severity: Notice  --> Undefined index: lname C:\xampp\shringar_live\application\views\rent\submitBooking.php 16
ERROR - 2013-10-18 12:30:43 --> #62, product_header.php error
ERROR - 2013-10-18 12:30:43 --> Array
(
)

ERROR - 2013-10-18 12:30:58 --> #62, product_header.php error
ERROR - 2013-10-18 12:30:58 --> Array
(
)

ERROR - 2013-10-18 12:31:00 --> #62, product_header.php error
ERROR - 2013-10-18 12:31:00 --> Array
(
)

ERROR - 2013-10-18 12:31:20 --> #62, product_header.php error
ERROR - 2013-10-18 12:31:20 --> Array
(
)

ERROR - 2013-10-18 12:31:33 --> Array
(
    [0] => Array
        (
            [id] => 13
            [name] => mfg_barcode
            [level] => 1
            [display_name] => Mfg. Barcode
        )

)

ERROR - 2013-10-18 12:32:27 --> #62, product_header.php error
ERROR - 2013-10-18 12:32:27 --> Array
(
)

ERROR - 2013-10-18 12:32:29 --> #62, product_header.php error
ERROR - 2013-10-18 12:32:29 --> Array
(
)

ERROR - 2013-10-18 12:32:29 --> #62, product_header.php error
ERROR - 2013-10-18 12:32:29 --> Array
(
)

ERROR - 2013-10-18 12:32:34 --> Array
(
    [0] => Array
        (
            [id] => 13
            [name] => mfg_barcode
            [level] => 1
            [display_name] => Mfg. Barcode
        )

)

ERROR - 2013-10-18 12:32:37 --> #62, product_header.php error
ERROR - 2013-10-18 12:32:37 --> Array
(
)

ERROR - 2013-10-18 12:33:32 --> #62, product_header.php error
ERROR - 2013-10-18 12:33:32 --> Array
(
)

ERROR - 2013-10-18 12:41:31 --> Array
(
    [bill_id] => 1
    [customer] => Array
        (
            [id] => 1
            [fname] => Walkin
            [lname] => 
            [dob] => 2012-08-22
            [sex] => 
            [phone] => 7411350398
            [email] => 
            [sms] => N
            [building] => 
            [street] => 
            [area] => 
            [city] => 
            [pin] => 
            [state] => 
            [user_id] => 3
            [loyalty_points] => 0
            [loyalty_points_valid_till] => 
        )

    [bill_subtotal] => 198
    [bill_amount] => 198
    [vat_amount] => 12.157894736842
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 2
                    [price_initial] => 99.00
                    [discount_amount] => 0
                    [price_without_vat] => 86.842105263158
                    [vat_amount] => 12.157894736842
                    [attributes] => Array
                        (
                            [0] => Array
                                (
                                    [price] => -99.00
                                    [name] => price
                                    [display_name] => MRP
                                    [value] => 
                                    [sku] => 1
                                )

                            [1] => Array
                                (
                                    [mfg_barcode] => 8901030174797
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [value] => 8901030174797
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 99.00
                                )

                        )

                    [id] => 3
                    [header_id] => 3
                    [price] => 99.00
                    [name] => LAK FACEMAGIC DAILY SHELL
                    [desc_id] => 3
                    [description] => 
                    [brand_id] => 1
                    [brand] => Lakme
                    [tax_category] => Cosmetics 14
                    [category_id] => 20
                    [vat_percentage] => 14
                    [class_id] => 134
                    [class] => Foundation
                    [details] => []
                    [header_mfg_barcode] => 8901030174797
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 99
                    [stock] => 2.000
                    [mrp_value] => 198.00000
                    [category_name] => Cosmetics 14
                    [final_amount] => 198
                )

        )

    [payment] => Array
        (
            [cash] => 198.00
            [card] => 0
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 198.00
                )

        )

    [status] => paid
    [date] => 22-08-2012
    [barcode] => 4060000001
    [print] => 0
)

ERROR - 2013-10-18 12:44:12 --> Array
(
    [bill_id] => 43848
    [customer] => Array
        (
            [id] => 1
            [fname] => Walkin
            [lname] => 
            [dob] => 2012-08-22
            [sex] => 
            [phone] => 7411350398
            [email] => 
            [sms] => N
            [building] => 
            [street] => 
            [area] => 
            [city] => 
            [pin] => 
            [state] => 
            [user_id] => 3
            [loyalty_points] => 0
            [loyalty_points_valid_till] => 
        )

    [bill_subtotal] => 950
    [bill_amount] => 855
    [vat_amount] => 108.27510917031
    [discount] => 47.5
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 917
                    [row_count] => 1
                    [discount] => 10
                    [quantity] => 2
                    [price_initial] => 475.00
                    [discount_amount] => 47.5
                    [price_without_vat] => 373.36244541485
                    [vat_amount] => 108.27510917031
                    [attributes] => Array
                        (
                            [0] => Array
                                (
                                    [price] => -99.00
                                    [name] => price
                                    [display_name] => MRP
                                    [id] => 9
                                    [level] => 1
                                    [sku] => 1
                                    [value] => 
                                )

                            [1] => Array
                                (
                                    [mfg_barcode] => 041554275704
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 041554275704
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 475.00
                                )

                        )

                    [id] => 917
                    [header_id] => 3531
                    [price] => 475.00
                    [name] => Maybelline Dream Lumi Touch Concealer 340 
                    [desc_id] => 3321
                    [description] => 
                    [brand_id] => 5
                    [brand] => MAYBELLINE
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 161
                    [class] => Concealer
                    [details] => []
                    [header_mfg_barcode] => 041554275704
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 427.5
                    [stock] => 5.000
                    [mrp_value] => 2375.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 855
                )

        )

    [payment] => Array
        (
            [cash] => 855.00
            [card] => 0
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 855.00
                )

        )

    [status] => paid
    [date] => 18-10-2013
    [barcode] => 4060043848
    [print] => 0
)

ERROR - 2013-10-18 12:44:53 --> Array
(
    [bill_id] => 43848
    [customer] => Array
        (
            [id] => 1
            [fname] => Walkin
            [lname] => 
            [dob] => 2012-08-22
            [sex] => 
            [phone] => 7411350398
            [email] => 
            [sms] => N
            [building] => 
            [street] => 
            [area] => 
            [city] => 
            [pin] => 
            [state] => 
            [user_id] => 3
            [loyalty_points] => 0
            [loyalty_points_valid_till] => 
        )

    [bill_subtotal] => 950
    [bill_amount] => 855
    [vat_amount] => 108.27510917031
    [discount] => 47.5
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 917
                    [row_count] => 1
                    [discount] => 10
                    [quantity] => 2
                    [price_initial] => 475.00
                    [discount_amount] => 47.5
                    [price_without_vat] => 373.36244541485
                    [vat_amount] => 108.27510917031
                    [attributes] => Array
                        (
                            [0] => Array
                                (
                                    [price] => -99.00
                                    [name] => price
                                    [display_name] => MRP
                                    [id] => 9
                                    [level] => 1
                                    [sku] => 1
                                    [value] => 
                                )

                            [1] => Array
                                (
                                    [mfg_barcode] => 041554275704
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 041554275704
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 475.00
                                )

                        )

                    [id] => 917
                    [header_id] => 3531
                    [price] => 475.00
                    [name] => Maybelline Dream Lumi Touch Concealer 340 
                    [desc_id] => 3321
                    [description] => 
                    [brand_id] => 5
                    [brand] => MAYBELLINE
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 161
                    [class] => Concealer
                    [details] => []
                    [header_mfg_barcode] => 041554275704
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 427.5
                    [stock] => 5.000
                    [mrp_value] => 2375.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 855
                )

        )

    [payment] => Array
        (
            [cash] => 855.00
            [card] => 0
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 855.00
                )

        )

    [status] => paid
    [date] => 18-10-2013
    [barcode] => 4060043848
    [print] => 0
)

