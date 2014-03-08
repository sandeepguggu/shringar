<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2013-11-18 07:59:12 --> Severity: Notice  --> Undefined index: customer-id C:\xampp\shringar_live\application\controllers\invoice.php 387
ERROR - 2013-11-18 07:59:12 --> Severity: Notice  --> Undefined index: item_id C:\xampp\shringar_live\application\controllers\invoice.php 398
ERROR - 2013-11-18 07:59:12 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\controllers\invoice.php 398
ERROR - 2013-11-18 07:59:12 --> Severity: Notice  --> Undefined index: total_bill_amount C:\xampp\shringar_live\application\controllers\invoice.php 424
ERROR - 2013-11-18 07:59:12 --> TOTAL BILL BACKEND0
ERROR - 2013-11-18 07:59:12 --> TOTAL BILL Frontend
ERROR - 2013-11-18 07:59:12 --> Query error: Column 'customer_id' cannot be null
ERROR - 2013-11-18 08:01:16 --> Array
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

ERROR - 2013-11-18 08:01:23 --> Array
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

ERROR - 2013-11-18 08:02:08 --> TOTAL BILL BACKEND275
ERROR - 2013-11-18 08:02:08 --> TOTAL BILL Frontend0
ERROR - 2013-11-18 08:02:08 --> Array
(
    [bill_id] => 43851
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

    [bill_subtotal] => 275
    [bill_amount] => 275
    [vat_amount] => 34.825327510917
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 20729
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 275.00
                    [discount_amount] => 0
                    [price_without_vat] => 240.17467248908
                    [vat_amount] => 34.825327510917
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
                                    [mfg_barcode] => 6923492577482
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 6923492577482
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 275.00
                                )

                        )

                    [id] => 20729
                    [header_id] => 1073
                    [price] => 275.00
                    [name] => Moisture Extreme  Pure Plum 844
                    [desc_id] => 1072
                    [description] => 
                    [brand_id] => 5
                    [brand] => MAYBELLINE
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 143
                    [class] => Lipstick
                    [details] => []
                    [header_mfg_barcode] => 6923492577482
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 275
                    [stock] => 2.000
                    [mrp_value] => 550.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 275
                )

        )

    [payment] => Array
        (
            [cash] => 175.00
            [card] => 200
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 175.00
                )

            [cards] => Array
                (
                    [amount] => 100
                    [0] => Array
                        (
                            [amount] => 100
                            [bank_name] => asd
                            [approval_code] => 123
                            [last_digits] => 4123
                        )

                )

        )

    [status] => paid
    [date] => 18-11-2013
    [barcode] => 4060043851
    [print] => 0
)

ERROR - 2013-11-18 08:02:49 --> Severity: Notice  --> Undefined index: item_id C:\xampp\shringar_live\application\controllers\invoice.php 398
ERROR - 2013-11-18 08:02:49 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\controllers\invoice.php 398
ERROR - 2013-11-18 08:05:31 --> Severity: Notice  --> Undefined index: customer-id C:\xampp\shringar_live\application\controllers\invoice.php 387
ERROR - 2013-11-18 08:05:31 --> Severity: Notice  --> Undefined index: item_id C:\xampp\shringar_live\application\controllers\invoice.php 398
ERROR - 2013-11-18 08:05:31 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\controllers\invoice.php 398
ERROR - 2013-11-18 08:05:31 --> Severity: Notice  --> Undefined index: total_bill_amount C:\xampp\shringar_live\application\controllers\invoice.php 424
ERROR - 2013-11-18 08:05:31 --> TOTAL BILL BACKEND0
ERROR - 2013-11-18 08:05:31 --> TOTAL BILL Frontend
ERROR - 2013-11-18 08:05:31 --> Query error: Column 'customer_id' cannot be null
ERROR - 2013-11-18 08:05:44 --> Severity: Notice  --> Undefined index: customer-id C:\xampp\shringar_live\application\controllers\invoice.php 387
ERROR - 2013-11-18 08:05:44 --> Severity: Notice  --> Undefined index: item_id C:\xampp\shringar_live\application\controllers\invoice.php 398
ERROR - 2013-11-18 08:05:44 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\controllers\invoice.php 398
ERROR - 2013-11-18 08:05:44 --> Severity: Notice  --> Undefined index: total_bill_amount C:\xampp\shringar_live\application\controllers\invoice.php 424
ERROR - 2013-11-18 08:05:44 --> TOTAL BILL BACKEND0
ERROR - 2013-11-18 08:05:44 --> TOTAL BILL Frontend
ERROR - 2013-11-18 08:05:44 --> Query error: Column 'customer_id' cannot be null
ERROR - 2013-11-18 08:07:26 --> Severity: Notice  --> Undefined index: customer-id C:\xampp\shringar_live\application\controllers\invoice.php 388
ERROR - 2013-11-18 08:07:26 --> Severity: Notice  --> Undefined index: item_id C:\xampp\shringar_live\application\controllers\invoice.php 399
ERROR - 2013-11-18 08:07:26 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\controllers\invoice.php 399
ERROR - 2013-11-18 08:07:26 --> Severity: Notice  --> Undefined index: total_bill_amount C:\xampp\shringar_live\application\controllers\invoice.php 425
ERROR - 2013-11-18 08:07:26 --> TOTAL BILL BACKEND0
ERROR - 2013-11-18 08:07:26 --> TOTAL BILL Frontend
ERROR - 2013-11-18 08:07:26 --> Query error: Column 'customer_id' cannot be null
ERROR - 2013-11-18 08:12:17 --> Array
(
    [status] => success
    [grn] => Array
        (
            [id] => 5
            [purchase_order_id] => 0
            [user_id] => 3
            [vendor_id] => 2
            [dated] => 1970-01-01 05:30:00
            [created_at] => 2012-08-22 19:23:38
            [extra_json] => {"vendor":{"id":"2","company_name":"GiriShree Enterprises","main_person_name":"","phone1":"","address":"","city":"","pin":"","phone2":"","mobile":"","comments":"","user_id":"3","deleted":"0","grn_date":"","po_date":""},"total_grn_price":6450,"po":"","po_products":[],"date":"22-08-2012","selected_products":{"25_15_1":{"id":"15","name":"LAK FLAWLESS MATTE MM","desc_id":"15","description":"","brand_id":"1","brand":"Lakme","tax_category":"Cosmetics 14.5","category_id":"20","vat_percentage":"14.5","class_id":"135","class":"Compact","details":"[]","header_mfg_barcode":"8901030177538","attributes":[{"read_only":"0","id":"9","name":"price","value":"265","level":"1"},{"read_only":"0","id":"13","name":"mfg_barcode","value":"8901030177538","level":"1"}],"model_name":"product_header","quantity":"10","weight":1,"max_discount":100,"purchase_price":"250","vat_rate":"14.5","sub_total":2500,"item_entity_id":"26","item_specific_id":10,"header_product_id":"26","header_product":"product_sku","rate":0,"barcode":"4260000010"},"25_3363_2":{"id":"3363","name":"Lak Absolute Foundation Brush","desc_id":"3163","description":"","brand_id":"1","brand":"Lakme","tax_category":"Cosmetics 14.5","category_id":"20","vat_percentage":"14.5","class_id":"244","class":"BRUSH","details":"[]","header_mfg_barcode":"8901030403583","attributes":[{"read_only":"0","id":"9","name":"price","value":"475","level":"1"},{"read_only":"0","id":"13","name":"mfg_barcode","value":"8901030403583","level":"1"}],"model_name":"product_header","quantity":"10","weight":1,"max_discount":100,"purchase_price":"395","vat_rate":"14.5","sub_total":3950,"item_entity_id":"26","item_specific_id":11,"header_product_id":"26","header_product":"product_sku","rate":0,"barcode":"4260000011"}}}
            [deleted] => 0
            [items] => Array
                (
                    [0] => Array
                        (
                            [id] => 12
                            [product_receive_note_id] => 5
                            [item_entity_id] => 26
                            [item_specific_id] => 10
                            [product_id] => 
                            [quantity] => 10.000
                            [weight] => 1.000
                            [rate] => 250.00
                            [purchase_price] => 250.00
                            [branch_id] => 1
                            [max_qnt] => -1
                            [quantity_returned] => 0.000
                            [weight_returned] => 0.000
                        )

                    [1] => Array
                        (
                            [id] => 13
                            [product_receive_note_id] => 5
                            [item_entity_id] => 26
                            [item_specific_id] => 11
                            [product_id] => 
                            [quantity] => 10.000
                            [weight] => 1.000
                            [rate] => 395.00
                            [purchase_price] => 395.00
                            [branch_id] => 1
                            [max_qnt] => -1
                            [quantity_returned] => 0.000
                            [weight_returned] => 0.000
                        )

                )

        )

    [vendor] => Array
        (
            [id] => 2
            [company_name] => GIRISHREE ENTERPRISES
            [main_person_name] => VISHWANATH
            [phone1] => 41204114
            [address] => 3/A NEW HIGH SCHOOL ROAD V V PURAM
            [city] => BANGALORE
            [pin] => 560004
            [phone2] => 9902027592
            [mobile] => 9945422667
            [comments] => DISTRIBUTORS OF ALL HUL PRODUCTS
            [user_id] => 3
            [deleted] => 0
        )

)

ERROR - 2013-11-18 08:14:20 --> Severity: Notice  --> Undefined variable: params C:\xampp\shringar_live\application\controllers\rent.php 670
ERROR - 2013-11-18 08:22:00 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 08:25:08 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 10:15:22 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 10:22:13 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 10:24:41 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 10:25:03 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 10:25:54 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 10:26:03 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 10:28:36 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:32:03 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:36:16 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:36:31 --> Severity: Notice  --> Undefined index: quantity C:\xampp\htdocs\shringar_live\application\controllers\rent.php 281
ERROR - 2013-11-18 10:37:05 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:37:14 --> Severity: Notice  --> Undefined index: quantity C:\xampp\htdocs\shringar_live\application\models\rent_product_model.php 82
ERROR - 2013-11-18 10:37:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''quantity'
                                    `category_id`,
                ' at line 5
ERROR - 2013-11-18 10:37:31 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:37:41 --> Severity: Notice  --> Undefined index: quantity C:\xampp\htdocs\shringar_live\application\models\rent_product_model.php 82
ERROR - 2013-11-18 10:37:41 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''quantity'
                                    `category_id`,
                ' at line 5
ERROR - 2013-11-18 10:39:12 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:39:23 --> Severity: Notice  --> Undefined index: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 313
ERROR - 2013-11-18 10:39:23 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\controllers\rent.php 313
ERROR - 2013-11-18 10:39:23 --> Severity: Notice  --> Undefined variable: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 319
ERROR - 2013-11-18 10:39:23 --> Severity: Notice  --> Undefined index: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 319
ERROR - 2013-11-18 10:40:04 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 10:40:10 --> Severity: Notice  --> Undefined index: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 312
ERROR - 2013-11-18 10:40:10 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\controllers\rent.php 312
ERROR - 2013-11-18 10:40:10 --> Severity: Notice  --> Undefined variable: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 318
ERROR - 2013-11-18 10:40:10 --> Severity: Notice  --> Undefined index: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 318
ERROR - 2013-11-18 10:42:08 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 57
ERROR - 2013-11-18 10:45:56 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:46:12 --> Query error: Column count doesn't match value count at row 1
ERROR - 2013-11-18 10:46:24 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:47:36 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:50:03 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:51:05 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 58
ERROR - 2013-11-18 10:53:33 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 10:53:38 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 10:53:38 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 10:53:45 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 10:53:45 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 10:54:00 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 10:54:00 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 10:56:13 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:56:24 --> Severity: Notice  --> Undefined index: rent_quantity C:\xampp\htdocs\shringar_live\application\models\rent_product_model.php 82
ERROR - 2013-11-18 10:56:24 --> Query error: Column 'quantity' cannot be null
ERROR - 2013-11-18 10:56:42 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 10:59:42 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 10:59:42 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:03:32 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:03:32 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:08:32 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 11:08:41 --> Severity: Notice  --> Undefined index: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 313
ERROR - 2013-11-18 11:08:41 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\controllers\rent.php 313
ERROR - 2013-11-18 11:08:41 --> Severity: Notice  --> Undefined variable: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 319
ERROR - 2013-11-18 11:08:41 --> Severity: Notice  --> Undefined index: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 319
ERROR - 2013-11-18 11:11:24 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:11:24 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:11:30 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 11:11:52 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:11:52 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:12:21 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:12:21 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:12:59 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:12:59 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:13:03 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:13:03 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:13:12 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 11:13:36 --> Severity: Notice  --> Undefined variable: params C:\xampp\htdocs\shringar_live\application\controllers\rent.php 205
ERROR - 2013-11-18 11:13:43 --> Severity: Notice  --> Undefined variable: params C:\xampp\htdocs\shringar_live\application\controllers\rent.php 205
ERROR - 2013-11-18 11:14:00 --> Severity: Notice  --> Undefined variable: params C:\xampp\htdocs\shringar_live\application\controllers\rent.php 205
ERROR - 2013-11-18 11:14:00 --> Severity: Notice  --> Undefined variable: params C:\xampp\htdocs\shringar_live\application\controllers\rent.php 205
ERROR - 2013-11-18 11:14:10 --> Severity: Notice  --> Undefined variable: params C:\xampp\htdocs\shringar_live\application\controllers\rent.php 205
ERROR - 2013-11-18 11:14:16 --> Severity: Notice  --> Undefined index: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 312
ERROR - 2013-11-18 11:14:16 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\controllers\rent.php 312
ERROR - 2013-11-18 11:14:16 --> Severity: Notice  --> Undefined index: components C:\xampp\htdocs\shringar_live\application\controllers\rent.php 318
ERROR - 2013-11-18 11:14:33 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:15:45 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 11:18:13 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 11:25:53 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:25:53 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:27:08 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:27:08 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:27:11 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:27:11 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:27:14 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:27:14 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:27:17 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:27:17 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:27:19 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:27:19 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:27:24 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:27:24 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 105
ERROR - 2013-11-18 11:27:26 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:31:21 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:31:21 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 109
ERROR - 2013-11-18 11:31:35 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:31:44 --> Severity: Notice  --> Undefined variable: params C:\xampp\htdocs\shringar_live\application\controllers\rent.php 205
ERROR - 2013-11-18 11:31:58 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:33:52 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:34:01 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:34:01 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 109
ERROR - 2013-11-18 11:34:43 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 11:34:43 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 109
ERROR - 2013-11-18 11:34:48 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 13:05:25 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\addProduct.php 63
ERROR - 2013-11-18 13:25:41 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
ERROR - 2013-11-18 13:32:43 --> Severity: Notice  --> Undefined variable: params C:\xampp\htdocs\shringar_live\application\controllers\rent.php 205
ERROR - 2013-11-18 13:33:27 --> Severity: Notice  --> Undefined variable: params C:\xampp\htdocs\shringar_live\application\controllers\rent.php 205
ERROR - 2013-11-18 13:50:29 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\rent\editProduct.php 66
