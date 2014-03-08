<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2012-12-19 08:23:24 --> TOTAL BILL BACKEND594
ERROR - 2012-12-19 08:23:24 --> TOTAL BILL Frontend0
ERROR - 2012-12-19 08:23:26 --> Array
(
    [bill_id] => 10930
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

    [bill_subtotal] => 594
    [bill_amount] => 594
    [vat_amount] => 75.222707423581
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 3
                    [price_initial] => 99.00
                    [discount_amount] => 0
                    [price_without_vat] => 86.46288209607
                    [vat_amount] => 37.61135371179
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
                                    [mfg_barcode] => 8901030174797
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
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
                    [brand] => LAKME
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 134
                    [class] => Foundation
                    [details] => []
                    [header_mfg_barcode] => 8901030174797
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 99
                    [stock] => 4.000
                    [mrp_value] => 396.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 297
                )

            [1] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 10219
                    [row_count] => 2
                    [discount] => 0
                    [quantity] => 3
                    [price_initial] => 99.00
                    [discount_amount] => 0
                    [price_without_vat] => 86.46288209607
                    [vat_amount] => 37.61135371179
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
                                    [mfg_barcode] => 8901030175084
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901030175084
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

                    [id] => 10219
                    [header_id] => 11
                    [price] => 99.00
                    [name] => LAK COMPACT COREL
                    [desc_id] => 11
                    [description] => 
                    [brand_id] => 1
                    [brand] => LAKME
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 135
                    [class] => Compact
                    [details] => []
                    [header_mfg_barcode] => 8901030175084
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 99
                    [stock] => 10.000
                    [mrp_value] => 990.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 297
                )

        )

    [payment] => Array
        (
            [cash] => 594.00
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
                    [amount] => 594.00
                )

        )

    [status] => paid
    [date] => 19-12-2012
    [barcode] => 4060010930
    [print] => 0
)

ERROR - 2012-12-19 08:29:46 --> Severity: Notice  --> Use of undefined constant brand_id - assumed 'brand_id' C:\xampp\shringar\application\views\inventory\stock.php 20
ERROR - 2012-12-19 08:32:01 --> Severity: Notice  --> Use of undefined constant brand_id - assumed 'brand_id' C:\xampp\shringar\application\views\inventory\stock.php 20
ERROR - 2012-12-19 08:32:05 --> Array
(
    [0] => Array
        (
            [sku] => 1
            [id] => 9
            [name] => price
            [level] => 1
            [display_name] => MRP
            [value] => -99.00
        )

    [1] => Array
        (
            [sku] => 0
            [id] => 13
            [name] => mfg_barcode
            [level] => 1
            [display_name] => Mfg. Barcode
            [value] => 8901030174803
        )

)

ERROR - 2012-12-19 08:32:12 --> Array
(
    [0] => Array
        (
            [sku] => 1
            [id] => 9
            [name] => price
            [level] => 1
            [display_name] => MRP
            [value] => -99.00
        )

    [1] => Array
        (
            [sku] => 0
            [id] => 13
            [name] => mfg_barcode
            [level] => 1
            [display_name] => Mfg. Barcode
            [value] => 8901030174803
        )

)

ERROR - 2012-12-19 08:32:26 --> Array
(
    [0] => Array
        (
            [sku] => 1
            [id] => 9
            [name] => price
            [level] => 1
            [display_name] => MRP
            [value] => -99.00
        )

    [1] => Array
        (
            [sku] => 0
            [id] => 13
            [name] => mfg_barcode
            [level] => 1
            [display_name] => Mfg. Barcode
            [value] => 8901030175671
        )

)

ERROR - 2012-12-19 10:03:06 --> Severity: Warning  --> array_push() expects at least 2 parameters, 1 given C:\xampp\shringar\application\controllers\inventory.php 316
ERROR - 2012-12-19 10:03:06 --> Severity: Warning  --> array_push() expects at least 2 parameters, 1 given C:\xampp\shringar\application\controllers\inventory.php 317
ERROR - 2012-12-19 10:03:06 --> Severity: Warning  --> array_push() expects at least 2 parameters, 1 given C:\xampp\shringar\application\controllers\inventory.php 316
ERROR - 2012-12-19 10:03:06 --> Severity: Warning  --> array_push() expects at least 2 parameters, 1 given C:\xampp\shringar\application\controllers\inventory.php 317
ERROR - 2012-12-19 10:03:07 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\inventory.php 341
ERROR - 2012-12-19 10:03:07 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\inventory.php 342
ERROR - 2012-12-19 10:03:07 --> Severity: Notice  --> Undefined variable: start_column C:\xampp\shringar\application\controllers\inventory.php 354
ERROR - 2012-12-19 10:03:26 --> Severity: Warning  --> array_push() expects at least 2 parameters, 1 given C:\xampp\shringar\application\controllers\inventory.php 316
ERROR - 2012-12-19 10:03:26 --> Severity: Warning  --> array_push() expects at least 2 parameters, 1 given C:\xampp\shringar\application\controllers\inventory.php 317
ERROR - 2012-12-19 10:03:26 --> Severity: Warning  --> array_push() expects at least 2 parameters, 1 given C:\xampp\shringar\application\controllers\inventory.php 316
ERROR - 2012-12-19 10:03:26 --> Severity: Warning  --> array_push() expects at least 2 parameters, 1 given C:\xampp\shringar\application\controllers\inventory.php 317
ERROR - 2012-12-19 10:03:26 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\inventory.php 341
ERROR - 2012-12-19 10:03:26 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\inventory.php 342
ERROR - 2012-12-19 10:03:26 --> Severity: Notice  --> Undefined variable: start_column C:\xampp\shringar\application\controllers\inventory.php 354
ERROR - 2012-12-19 10:06:36 --> Severity: Warning  --> array_push() expects parameter 1 to be array, string given C:\xampp\shringar\application\controllers\inventory.php 316
ERROR - 2012-12-19 10:06:36 --> Severity: Warning  --> array_push() expects parameter 1 to be array, string given C:\xampp\shringar\application\controllers\inventory.php 317
ERROR - 2012-12-19 10:06:36 --> Severity: Warning  --> array_push() expects parameter 1 to be array, string given C:\xampp\shringar\application\controllers\inventory.php 316
ERROR - 2012-12-19 10:06:36 --> Severity: Warning  --> array_push() expects parameter 1 to be array, string given C:\xampp\shringar\application\controllers\inventory.php 317
ERROR - 2012-12-19 10:06:36 --> Severity: Notice  --> Undefined variable: start_column C:\xampp\shringar\application\controllers\inventory.php 354
ERROR - 2012-12-19 10:08:07 --> Severity: Notice  --> Undefined variable: start_column C:\xampp\shringar\application\controllers\inventory.php 354
ERROR - 2012-12-19 10:14:02 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\master.php 98
ERROR - 2012-12-19 10:14:02 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\master.php 99
ERROR - 2012-12-19 10:14:58 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\master.php 98
ERROR - 2012-12-19 10:14:58 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\master.php 99
ERROR - 2012-12-19 10:15:06 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\master.php 98
ERROR - 2012-12-19 10:15:06 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\master.php 99
ERROR - 2012-12-19 10:26:42 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\master.php 98
ERROR - 2012-12-19 10:26:42 --> Severity: Notice  --> Undefined index: Quantity C:\xampp\shringar\application\controllers\master.php 99
ERROR - 2012-12-19 11:49:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''20',20' at line 1
ERROR - 2012-12-19 11:53:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''40', 20' at line 1
ERROR - 2012-12-19 12:59:04 --> Severity: Warning  --> Missing argument 3 for Bill_Model::getAllBillItems(), called in C:\xampp\shringar\application\controllers\inventory.php on line 237 and defined C:\xampp\shringar\application\models\bill_model.php 237
ERROR - 2012-12-19 12:59:04 --> Severity: Warning  --> Missing argument 4 for Bill_Model::getAllBillItems(), called in C:\xampp\shringar\application\controllers\inventory.php on line 237 and defined C:\xampp\shringar\application\models\bill_model.php 237
ERROR - 2012-12-19 12:59:04 --> Severity: Notice  --> Undefined variable: start C:\xampp\shringar\application\models\bill_model.php 247
ERROR - 2012-12-19 12:59:04 --> Severity: Notice  --> Undefined variable: limit C:\xampp\shringar\application\models\bill_model.php 247
ERROR - 2012-12-19 12:59:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'NULL, NULL' at line 1
ERROR - 2012-12-19 13:05:26 --> Severity: Notice  --> Undefined variable: query C:\xampp\shringar\application\models\bill_model.php 246
ERROR - 2012-12-19 14:08:42 --> Severity: Notice  --> Use of undefined constant brand_id - assumed 'brand_id' C:\xampp\shringar\application\views\inventory\stock.php 20
ERROR - 2012-12-19 14:20:15 --> Severity: Notice  --> Use of undefined constant brand_id - assumed 'brand_id' C:\xampp\shringar\application\views\inventory\stock.php 20
