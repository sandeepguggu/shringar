<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2013-10-21 13:45:45 --> Array
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

ERROR - 2013-10-21 13:46:38 --> Severity: Notice  --> Undefined index: category_id C:\xampp\shringar_live\application\libraries\ProductLib.php 70
ERROR - 2013-10-21 13:46:38 --> Severity: Warning  --> array_merge(): Argument #2 is not an array C:\xampp\shringar_live\application\libraries\ProductLib.php 70
ERROR - 2013-10-21 13:46:38 --> Severity: Warning  --> array_merge(): Argument #2 is not an array C:\xampp\shringar_live\application\controllers\grn.php 309
ERROR - 2013-10-21 13:46:38 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\views\grn\print_grn.php 113
ERROR - 2013-10-21 13:46:56 --> Severity: Notice  --> Undefined index: category_id C:\xampp\shringar_live\application\libraries\ProductLib.php 70
ERROR - 2013-10-21 13:46:56 --> Severity: Warning  --> array_merge(): Argument #2 is not an array C:\xampp\shringar_live\application\libraries\ProductLib.php 70
ERROR - 2013-10-21 13:46:56 --> Severity: Warning  --> array_merge(): Argument #2 is not an array C:\xampp\shringar_live\application\controllers\grn.php 309
ERROR - 2013-10-21 13:46:56 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\shringar_live\application\views\grn\print_grn.php 113
