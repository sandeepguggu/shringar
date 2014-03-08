<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2013-11-27 06:19:29 --> Bill - Exchange BillArray
(
    [id] => 43858
    [created_at] => 2013-11-25 18:02:23
    [user_id] => 5
    [paid_by_cash] => 40.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 5.07
    [vat_discount] => 0
    [total_amount] => 40.00
    [final_amount] => 40.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 06:19:39 --> Bill - Exchange BillArray
(
    [id] => 43857
    [created_at] => 2013-11-18 12:30:19
    [user_id] => 5
    [paid_by_cash] => 80.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 10.13
    [vat_discount] => 0
    [total_amount] => 80.00
    [final_amount] => 80.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 06:19:39 --> Array
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
            [mfg_barcode] => 8906050590121
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906050590121
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 40.00
        )

)

ERROR - 2013-11-27 06:22:51 --> Array
(
    [bill_id] => 43856
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

    [bill_subtotal] => 30
    [bill_amount] => 30
    [vat_amount] => 3.7991266375546
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 2136
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 30.00
                    [discount_amount] => 0
                    [price_without_vat] => 26.200873362445
                    [vat_amount] => 3.7991266375546
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
                                    [mfg_barcode] => 8906026330010
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8906026330010
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 30.00
                                )

                        )

                    [id] => 2136
                    [header_id] => 3989
                    [price] => 30.00
                    [name] => AMLA POWDER 100 GM
                    [desc_id] => 3754
                    [description] => 
                    [brand_id] => 10
                    [brand] => AYUR
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 407
                    [class] => AYUR AMLA POWDER
                    [details] => []
                    [header_mfg_barcode] => 8906026330010
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 30
                    [stock] => 1.000
                    [mrp_value] => 30.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 30
                )

        )

    [payment] => Array
        (
            [cash] => 30.00
            [card] => 60
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 30.00
                )

            [cards] => Array
                (
                    [amount] => 30
                    [0] => Array
                        (
                            [amount] => 30
                            [bank_name] => fvf
                            [approval_code] => 111
                            [last_digits] => 1111111111111111
                        )

                )

        )

    [status] => paid
    [date] => 15-11-2013
    [barcode] => 4060043856
    [print] => 0
)

ERROR - 2013-11-27 06:22:51 --> Array
(
    [bill_id] => 43856
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

    [bill_subtotal] => 30
    [bill_amount] => 30
    [vat_amount] => 3.7991266375546
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 2136
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 30.00
                    [discount_amount] => 0
                    [price_without_vat] => 26.200873362445
                    [vat_amount] => 3.7991266375546
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
                                    [mfg_barcode] => 8906026330010
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8906026330010
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 30.00
                                )

                        )

                    [id] => 2136
                    [header_id] => 3989
                    [price] => 30.00
                    [name] => AMLA POWDER 100 GM
                    [desc_id] => 3754
                    [description] => 
                    [brand_id] => 10
                    [brand] => AYUR
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 407
                    [class] => AYUR AMLA POWDER
                    [details] => []
                    [header_mfg_barcode] => 8906026330010
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 30
                    [stock] => 1.000
                    [mrp_value] => 30.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 30
                )

        )

    [payment] => Array
        (
            [cash] => 30.00
            [card] => 60
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 30.00
                )

            [cards] => Array
                (
                    [amount] => 30
                    [0] => Array
                        (
                            [amount] => 30
                            [bank_name] => fvf
                            [approval_code] => 111
                            [last_digits] => 1111111111111111
                        )

                )

        )

    [status] => paid
    [date] => 15-11-2013
    [barcode] => 4060043856
    [print] => 0
)

ERROR - 2013-11-27 06:22:51 --> Array
(
    [bill_id] => 43856
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

    [bill_subtotal] => 30
    [bill_amount] => 30
    [vat_amount] => 3.7991266375546
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 2136
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 30.00
                    [discount_amount] => 0
                    [price_without_vat] => 26.200873362445
                    [vat_amount] => 3.7991266375546
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
                                    [mfg_barcode] => 8906026330010
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8906026330010
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 30.00
                                )

                        )

                    [id] => 2136
                    [header_id] => 3989
                    [price] => 30.00
                    [name] => AMLA POWDER 100 GM
                    [desc_id] => 3754
                    [description] => 
                    [brand_id] => 10
                    [brand] => AYUR
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 407
                    [class] => AYUR AMLA POWDER
                    [details] => []
                    [header_mfg_barcode] => 8906026330010
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 30
                    [stock] => 1.000
                    [mrp_value] => 30.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 30
                )

        )

    [payment] => Array
        (
            [cash] => 30.00
            [card] => 60
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 30.00
                )

            [cards] => Array
                (
                    [amount] => 30
                    [0] => Array
                        (
                            [amount] => 30
                            [bank_name] => fvf
                            [approval_code] => 111
                            [last_digits] => 1111111111111111
                        )

                )

        )

    [status] => paid
    [date] => 15-11-2013
    [barcode] => 4060043856
    [print] => 0
)

ERROR - 2013-11-27 06:22:54 --> Array
(
    [bill_id] => 43855
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

    [bill_subtotal] => 0
    [bill_amount] => 0
    [vat_amount] => 0
    [discount] => 0
    [products] => Array
        (
        )

    [payment] => Array
        (
            [cash] => 12
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
                    [amount] => 12
                )

        )

    [status] => paid
    [date] => 15-11-2013
    [barcode] => 4060043855
    [print] => 0
)

ERROR - 2013-11-27 06:22:54 --> #4, po/printpo.php error
ERROR - 2013-11-27 06:22:57 --> Array
(
    [bill_id] => 43854
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

    [bill_subtotal] => 299
    [bill_amount] => 299
    [vat_amount] => 37.864628820961
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 7545
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 299.00
                    [discount_amount] => 0
                    [price_without_vat] => 261.13537117904
                    [vat_amount] => 37.864628820961
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
                                    [mfg_barcode] => 627762290014
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 627762290014
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 299.00
                                )

                        )

                    [id] => 7545
                    [header_id] => 2008
                    [price] => 299.00
                    [name] => BLACK Liner
                    [desc_id] => 1981
                    [description] => 
                    [brand_id] => 8
                    [brand] => FACES
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 155
                    [class] => Eye Liner
                    [details] => []
                    [header_mfg_barcode] => 627762290014
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 299
                    [stock] => 1.000
                    [mrp_value] => 299.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 299
                )

        )

    [payment] => Array
        (
            [cash] => 299.00
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
                    [amount] => 299.00
                )

        )

    [status] => paid
    [date] => 08-11-2013
    [barcode] => 4060043854
    [print] => 0
)

ERROR - 2013-11-27 06:23:34 --> Bill - Exchange BillArray
(
    [id] => 43854
    [created_at] => 2013-11-08 11:32:38
    [user_id] => 5
    [paid_by_cash] => 299.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 37.86
    [vat_discount] => 0
    [total_amount] => 299.00
    [final_amount] => 299.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 06:23:34 --> Array
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
            [mfg_barcode] => 627762290014
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 627762290014
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 299.00
        )

)

ERROR - 2013-11-27 06:23:37 --> Array
(
    [tab] => exchange
    [bill_items] => Array
        (
            [0] => Array
                (
                    [id] => 124298
                    [bill_id] => 43854
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 7545
                    [quantity] => 1.000
                    [weight] => 0.000
                    [price] => 299.00
                    [vat] => 37.865
                    [discount] => 0.000
                    [final_amount] => 299.00
                    [branch_id] => 0
                    [credit_note_id] => 0
                    [returned_qty] => 0.000
                )

        )

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

    [selected_products] => Array
        (
            [124298] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 7545
                    [bill_item_id] => 124298
                    [quantity] => 1
                    [weight] => 0
                    [price] => 299.00
                    [name] => BLACK Liner
                    [discount] => 0
                    [vat_percentage] => 14.5
                    [final_amount] => 299
                )

        )

    [total_credit_note] => 299
    [credit_note_id] => 579
    [date] => 2013-11-27 10:53:36
    [barcode] => 4100000579
    [print] => 0
)

ERROR - 2013-11-27 06:39:13 --> Array
(
    [bill_id] => 43856
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

    [bill_subtotal] => 30
    [bill_amount] => 30
    [vat_amount] => 3.7991266375546
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 2136
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 30.00
                    [discount_amount] => 0
                    [price_without_vat] => 26.200873362445
                    [vat_amount] => 3.7991266375546
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
                                    [mfg_barcode] => 8906026330010
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8906026330010
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 30.00
                                )

                        )

                    [id] => 2136
                    [header_id] => 3989
                    [price] => 30.00
                    [name] => AMLA POWDER 100 GM
                    [desc_id] => 3754
                    [description] => 
                    [brand_id] => 10
                    [brand] => AYUR
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 407
                    [class] => AYUR AMLA POWDER
                    [details] => []
                    [header_mfg_barcode] => 8906026330010
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 30
                    [stock] => 1.000
                    [mrp_value] => 30.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 30
                )

        )

    [payment] => Array
        (
            [cash] => 30.00
            [card] => 60
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 30.00
                )

            [cards] => Array
                (
                    [amount] => 30
                    [0] => Array
                        (
                            [amount] => 30
                            [bank_name] => fvf
                            [approval_code] => 111
                            [last_digits] => 1111111111111111
                        )

                )

        )

    [status] => paid
    [date] => 15-11-2013
    [barcode] => 4060043856
    [print] => 0
)

ERROR - 2013-11-27 06:39:13 --> Array
(
    [bill_id] => 43856
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

    [bill_subtotal] => 30
    [bill_amount] => 30
    [vat_amount] => 3.7991266375546
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 2136
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 30.00
                    [discount_amount] => 0
                    [price_without_vat] => 26.200873362445
                    [vat_amount] => 3.7991266375546
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
                                    [mfg_barcode] => 8906026330010
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8906026330010
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 30.00
                                )

                        )

                    [id] => 2136
                    [header_id] => 3989
                    [price] => 30.00
                    [name] => AMLA POWDER 100 GM
                    [desc_id] => 3754
                    [description] => 
                    [brand_id] => 10
                    [brand] => AYUR
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 407
                    [class] => AYUR AMLA POWDER
                    [details] => []
                    [header_mfg_barcode] => 8906026330010
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 30
                    [stock] => 1.000
                    [mrp_value] => 30.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 30
                )

        )

    [payment] => Array
        (
            [cash] => 30.00
            [card] => 60
            [scheme] => 0
            [loyalty] => 0
            [purchase_bill_amt] => 0
            [order_advance] => not applied
        )

    [new_payment] => Array
        (
            [cash] => Array
                (
                    [amount] => 30.00
                )

            [cards] => Array
                (
                    [amount] => 30
                    [0] => Array
                        (
                            [amount] => 30
                            [bank_name] => fvf
                            [approval_code] => 111
                            [last_digits] => 1111111111111111
                        )

                )

        )

    [status] => paid
    [date] => 15-11-2013
    [barcode] => 4060043856
    [print] => 0
)

ERROR - 2013-11-27 06:39:24 --> Bill - Exchange BillArray
(
    [id] => 43856
    [created_at] => 2013-11-15 17:09:17
    [user_id] => 5
    [paid_by_cash] => 30.00
    [paid_by_card] => 60.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 3.80
    [vat_discount] => 0
    [total_amount] => 30.00
    [final_amount] => 30.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 06:39:24 --> Array
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
            [mfg_barcode] => 8906026330010
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906026330010
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 30.00
        )

)

ERROR - 2013-11-27 06:39:24 --> Bill - Exchange BillArray
(
    [id] => 43856
    [created_at] => 2013-11-15 17:09:17
    [user_id] => 5
    [paid_by_cash] => 30.00
    [paid_by_card] => 60.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 3.80
    [vat_discount] => 0
    [total_amount] => 30.00
    [final_amount] => 30.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 06:39:24 --> Array
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
            [mfg_barcode] => 8906026330010
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906026330010
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 30.00
        )

)

ERROR - 2013-11-27 06:39:28 --> Query error: Unknown column 'bill_id' in 'where clause'
ERROR - 2013-11-27 06:41:52 --> Severity: Notice  --> Undefined variable: r C:\xampp\htdocs\shringar_live\application\models\bill_model.php 76
ERROR - 2013-11-27 06:41:52 --> Array
(
    [tab] => exchange
    [bill_items] => Array
        (
            [0] => Array
                (
                    [id] => 124299
                    [bill_id] => 43856
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 2136
                    [quantity] => 1.000
                    [weight] => 0.000
                    [price] => 30.00
                    [vat] => 3.799
                    [discount] => 0.000
                    [final_amount] => 30.00
                    [branch_id] => 0
                    [credit_note_id] => 0
                    [returned_qty] => 0.000
                )

        )

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

    [selected_products] => Array
        (
            [124299] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 2136
                    [bill_item_id] => 124299
                    [quantity] => 1
                    [weight] => 0
                    [price] => 30.00
                    [name] => AMLA POWDER 100 GM
                    [discount] => 0
                    [vat_percentage] => 14.5
                    [final_amount] => 30
                )

        )

    [total_credit_note] => 30
    [credit_note_id] => 581
    [date] => 2013-11-27 11:11:52
    [barcode] => 4100000581
    [print] => 0
)

ERROR - 2013-11-27 06:59:45 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 06:59:50 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 07:01:08 --> Bill - Exchange BillArray
(
    [id] => 43855
    [created_at] => 2013-11-15 16:53:23
    [user_id] => 5
    [paid_by_cash] => 12.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 0.00
    [vat_discount] => 0
    [total_amount] => 0.00
    [final_amount] => 0.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 07:01:08 --> 
ERROR - 2013-11-27 07:01:08 --> Bill - Exchange BillArray
(
    [id] => 43855
    [created_at] => 2013-11-15 16:53:23
    [user_id] => 5
    [paid_by_cash] => 12.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 0.00
    [vat_discount] => 0
    [total_amount] => 0.00
    [final_amount] => 0.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 07:01:08 --> 
ERROR - 2013-11-27 07:01:18 --> Bill - Exchange BillArray
(
    [id] => 43856
    [created_at] => 2013-11-15 17:09:17
    [user_id] => 5
    [paid_by_cash] => 30.00
    [paid_by_card] => 60.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 3.80
    [vat_discount] => 0
    [total_amount] => 30.00
    [final_amount] => 30.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 07:01:18 --> 
ERROR - 2013-11-27 07:01:18 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 66
ERROR - 2013-11-27 07:01:18 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 67
ERROR - 2013-11-27 07:01:41 --> Bill - Exchange BillArray
(
    [id] => 43856
    [created_at] => 2013-11-15 17:09:17
    [user_id] => 5
    [paid_by_cash] => 30.00
    [paid_by_card] => 60.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 3.80
    [vat_discount] => 0
    [total_amount] => 30.00
    [final_amount] => 30.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 07:01:41 --> 
ERROR - 2013-11-27 07:01:41 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 66
ERROR - 2013-11-27 07:01:41 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 67
ERROR - 2013-11-27 08:51:45 --> Bill - Exchange BillArray
(
    [id] => 43856
    [created_at] => 2013-11-15 17:09:17
    [user_id] => 5
    [paid_by_cash] => 30.00
    [paid_by_card] => 60.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 3.80
    [vat_discount] => 0
    [total_amount] => 30.00
    [final_amount] => 30.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:51:45 --> 
ERROR - 2013-11-27 08:51:45 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 66
ERROR - 2013-11-27 08:51:45 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 67
ERROR - 2013-11-27 08:56:06 --> Bill - Exchange BillArray
(
    [id] => 43856
    [created_at] => 2013-11-15 17:09:17
    [user_id] => 5
    [paid_by_cash] => 30.00
    [paid_by_card] => 60.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 3.80
    [vat_discount] => 0
    [total_amount] => 30.00
    [final_amount] => 30.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:56:06 --> 
ERROR - 2013-11-27 08:56:06 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 66
ERROR - 2013-11-27 08:56:06 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 67
ERROR - 2013-11-27 08:56:26 --> Bill - Exchange BillArray
(
    [id] => 43858
    [created_at] => 2013-11-25 18:02:23
    [user_id] => 5
    [paid_by_cash] => 40.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 5.07
    [vat_discount] => 0
    [total_amount] => 40.00
    [final_amount] => 40.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:56:36 --> Bill - Exchange BillArray
(
    [id] => 43851
    [created_at] => 2013-11-07 11:09:58
    [user_id] => 5
    [paid_by_cash] => 110.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 13.93
    [vat_discount] => 0
    [total_amount] => 110.00
    [final_amount] => 110.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:56:36 --> Array
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
            [mfg_barcode] => 4902430322669
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 4902430322669
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 110.00
        )

)

ERROR - 2013-11-27 08:56:53 --> Bill - Exchange BillArray
(
    [id] => 43851
    [created_at] => 2013-11-07 11:09:58
    [user_id] => 5
    [paid_by_cash] => 110.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 13.93
    [vat_discount] => 0
    [total_amount] => 110.00
    [final_amount] => 110.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:56:53 --> Array
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
            [mfg_barcode] => 4902430322669
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 4902430322669
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 110.00
        )

)

ERROR - 2013-11-27 08:57:05 --> Bill - Exchange BillArray
(
    [id] => 43851
    [created_at] => 2013-11-07 11:09:58
    [user_id] => 5
    [paid_by_cash] => 110.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 13.93
    [vat_discount] => 0
    [total_amount] => 110.00
    [final_amount] => 110.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:57:05 --> Array
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
            [mfg_barcode] => 4902430322669
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 4902430322669
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 110.00
        )

)

ERROR - 2013-11-27 08:57:09 --> Bill - Exchange BillArray
(
    [id] => 43852
    [created_at] => 2013-11-07 11:35:26
    [user_id] => 5
    [paid_by_cash] => 299.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 37.86
    [vat_discount] => 0
    [total_amount] => 299.00
    [final_amount] => 299.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:57:09 --> Bill - Exchange BillArray
(
    [id] => 43852
    [created_at] => 2013-11-07 11:35:26
    [user_id] => 5
    [paid_by_cash] => 299.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 37.86
    [vat_discount] => 0
    [total_amount] => 299.00
    [final_amount] => 299.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:57:15 --> Bill - Exchange BillArray
(
    [id] => 43853
    [created_at] => 2013-11-08 11:30:33
    [user_id] => 5
    [paid_by_cash] => 199.00
    [paid_by_card] => 100.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 37.86
    [vat_discount] => 0
    [total_amount] => 299.00
    [final_amount] => 299.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:57:20 --> Bill - Exchange BillArray
(
    [id] => 43854
    [created_at] => 2013-11-08 11:32:38
    [user_id] => 5
    [paid_by_cash] => 299.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 37.86
    [vat_discount] => 0
    [total_amount] => 299.00
    [final_amount] => 299.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:57:26 --> Bill - Exchange BillArray
(
    [id] => 43855
    [created_at] => 2013-11-15 16:53:23
    [user_id] => 5
    [paid_by_cash] => 12.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 0.00
    [vat_discount] => 0
    [total_amount] => 0.00
    [final_amount] => 0.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:57:26 --> 
ERROR - 2013-11-27 08:57:32 --> Bill - Exchange BillArray
(
    [id] => 43856
    [created_at] => 2013-11-15 17:09:17
    [user_id] => 5
    [paid_by_cash] => 30.00
    [paid_by_card] => 60.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 3.80
    [vat_discount] => 0
    [total_amount] => 30.00
    [final_amount] => 30.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:57:32 --> 
ERROR - 2013-11-27 08:57:32 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 66
ERROR - 2013-11-27 08:57:32 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 67
ERROR - 2013-11-27 08:57:38 --> Bill - Exchange BillArray
(
    [id] => 43857
    [created_at] => 2013-11-18 12:30:19
    [user_id] => 5
    [paid_by_cash] => 80.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 10.13
    [vat_discount] => 0
    [total_amount] => 80.00
    [final_amount] => 80.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:57:38 --> Array
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
            [mfg_barcode] => 8906050590121
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906050590121
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 40.00
        )

)

ERROR - 2013-11-27 08:58:19 --> Bill - Exchange BillArray
(
    [id] => 43858
    [created_at] => 2013-11-25 18:02:23
    [user_id] => 5
    [paid_by_cash] => 40.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 5.07
    [vat_discount] => 0
    [total_amount] => 40.00
    [final_amount] => 40.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:58:34 --> Bill - Exchange BillArray
(
    [id] => 43856
    [created_at] => 2013-11-15 17:09:17
    [user_id] => 5
    [paid_by_cash] => 30.00
    [paid_by_card] => 60.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 3.80
    [vat_discount] => 0
    [total_amount] => 30.00
    [final_amount] => 30.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 08:58:34 --> 
ERROR - 2013-11-27 08:58:34 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 66
ERROR - 2013-11-27 08:58:34 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 67
ERROR - 2013-11-27 09:01:38 --> Bill - Exchange BillArray
(
    [id] => 43856
    [created_at] => 2013-11-15 17:09:17
    [user_id] => 5
    [paid_by_cash] => 30.00
    [paid_by_card] => 60.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 3.80
    [vat_discount] => 0
    [total_amount] => 30.00
    [final_amount] => 30.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-27 09:01:38 --> 
ERROR - 2013-11-27 09:01:38 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 66
ERROR - 2013-11-27 09:01:38 --> Severity: Notice  --> Undefined offset: 0 C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 67
ERROR - 2013-11-27 09:02:13 --> Severity: Notice  --> Undefined index: created_at C:\xampp\htdocs\shringar_live\application\controllers\invoice.php 682
ERROR - 2013-11-27 09:02:13 --> Severity: Notice  --> Undefined index: full_json C:\xampp\htdocs\shringar_live\application\controllers\invoice.php 687
ERROR - 2013-11-27 09:02:13 --> Bill - Exchange BillArray
(
    [full_json] => 
)

ERROR - 2013-11-27 09:02:13 --> Severity: Notice  --> Undefined index: id C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 32
ERROR - 2013-11-27 09:02:13 --> Severity: Notice  --> Undefined index: id C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 33
ERROR - 2013-11-27 09:02:13 --> Severity: Notice  --> Undefined index: created_at C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 38
ERROR - 2013-11-27 09:02:13 --> 
ERROR - 2013-11-27 09:02:13 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\exchange_bill.php 63
ERROR - 2013-11-27 09:58:56 --> Bill - Exchange BillArray
(
    [id] => 43855
    [created_at] => 2013-11-15 16:53:23
    [user_id] => 5
    [paid_by_cash] => 12.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 0.00
    [vat_discount] => 0
    [total_amount] => 0.00
    [final_amount] => 0.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 09:58:56 --> 
ERROR - 2013-11-27 09:59:02 --> Bill - Exchange BillArray
(
    [id] => 43854
    [created_at] => 2013-11-08 11:32:38
    [user_id] => 5
    [paid_by_cash] => 299.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 37.86
    [vat_discount] => 0
    [total_amount] => 299.00
    [final_amount] => 299.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 09:59:09 --> Bill - Exchange BillArray
(
    [id] => 43853
    [created_at] => 2013-11-08 11:30:33
    [user_id] => 5
    [paid_by_cash] => 199.00
    [paid_by_card] => 100.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 37.86
    [vat_discount] => 0
    [total_amount] => 299.00
    [final_amount] => 299.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 09:59:18 --> Bill - Exchange BillArray
(
    [id] => 43852
    [created_at] => 2013-11-07 11:35:26
    [user_id] => 5
    [paid_by_cash] => 299.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 37.86
    [vat_discount] => 0
    [total_amount] => 299.00
    [final_amount] => 299.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 09:59:18 --> Bill - Exchange BillArray
(
    [id] => 43852
    [created_at] => 2013-11-07 11:35:26
    [user_id] => 5
    [paid_by_cash] => 299.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 37.86
    [vat_discount] => 0
    [total_amount] => 299.00
    [final_amount] => 299.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 09:59:41 --> Bill - Exchange BillArray
(
    [id] => 43857
    [created_at] => 2013-11-18 12:30:19
    [user_id] => 5
    [paid_by_cash] => 80.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 10.13
    [vat_discount] => 0
    [total_amount] => 80.00
    [final_amount] => 80.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 09:59:41 --> Array
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
            [mfg_barcode] => 8906050590121
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906050590121
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 40.00
        )

)

ERROR - 2013-11-27 09:59:47 --> Array
(
    [tab] => exchange
    [bill_items] => Array
        (
            [0] => Array
                (
                    [id] => 124300
                    [bill_id] => 43857
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [quantity] => 2.000
                    [weight] => 0.000
                    [price] => 40.00
                    [vat] => 10.131
                    [discount] => 0.000
                    [final_amount] => 80.00
                    [branch_id] => 0
                    [credit_note_id] => 0
                    [returned_qty] => 0.000
                    [exchange] => 0
                )

        )

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

    [selected_products] => Array
        (
            [124300] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [bill_item_id] => 124300
                    [quantity] => 2
                    [weight] => 0
                    [price] => 40.00
                    [name] => AMLA POWDER 100 GM
                    [discount] => 0
                    [vat_percentage] => 14.5
                    [final_amount] => 80
                )

        )

    [total_credit_note] => 80
    [credit_note_id] => 582
    [date] => 2013-11-27 14:29:47
    [barcode] => 4100000582
    [print] => 0
)

ERROR - 2013-11-27 10:01:53 --> Bill - Exchange BillArray
(
    [id] => 43857
    [created_at] => 2013-11-18 12:30:19
    [user_id] => 5
    [paid_by_cash] => 80.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 10.13
    [vat_discount] => 0
    [total_amount] => 80.00
    [final_amount] => 80.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 10:01:53 --> Bill - Exchange BillArray
(
    [id] => 43857
    [created_at] => 2013-11-18 12:30:19
    [user_id] => 5
    [paid_by_cash] => 80.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 10.13
    [vat_discount] => 0
    [total_amount] => 80.00
    [final_amount] => 80.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 10:05:13 --> Array
(
    [bill_id] => 43857
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

    [bill_subtotal] => 80
    [bill_amount] => 80
    [vat_amount] => 10.131004366812
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 2
                    [price_initial] => 40.00
                    [discount_amount] => 0
                    [price_without_vat] => 34.934497816594
                    [vat_amount] => 10.131004366812
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
                                    [mfg_barcode] => 8906050590121
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8906050590121
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 40.00
                                )

                        )

                    [id] => 3372
                    [header_id] => 4822
                    [price] => 40.00
                    [name] => AMLA POWDER 100 GM
                    [desc_id] => 3754
                    [description] => 
                    [brand_id] => 75
                    [brand] => BANJARAS
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 378
                    [class] => Powder
                    [details] => []
                    [header_mfg_barcode] => 8906050590121
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 40
                    [stock] => 7.000
                    [mrp_value] => 280.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 80
                )

        )

    [payment] => Array
        (
            [cash] => 80.00
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
                    [amount] => 80.00
                )

        )

    [status] => paid
    [date] => 18-11-2013
    [barcode] => 4060043857
    [print] => 0
)

ERROR - 2013-11-27 10:08:36 --> Bill - Exchange BillArray
(
    [id] => 43857
    [created_at] => 2013-11-18 12:30:19
    [user_id] => 5
    [paid_by_cash] => 80.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 10.13
    [vat_discount] => 0
    [total_amount] => 80.00
    [final_amount] => 80.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 10:08:45 --> Bill - Exchange BillArray
(
    [id] => 43855
    [created_at] => 2013-11-15 16:53:23
    [user_id] => 5
    [paid_by_cash] => 12.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 0.00
    [vat_discount] => 0
    [total_amount] => 0.00
    [final_amount] => 0.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 10:08:45 --> 
ERROR - 2013-11-27 10:09:32 --> TOTAL BILL BACKEND40
ERROR - 2013-11-27 10:09:32 --> TOTAL BILL Frontend0
ERROR - 2013-11-27 10:09:32 --> TOTAL BILL BACKEND40
ERROR - 2013-11-27 10:09:32 --> TOTAL BILL Frontend0
ERROR - 2013-11-27 10:09:32 --> Array
(
    [bill_id] => 43860
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

    [bill_subtotal] => 40
    [bill_amount] => 40
    [vat_amount] => 5.0655021834061
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 40.00
                    [discount_amount] => 0
                    [price_without_vat] => 34.934497816594
                    [vat_amount] => 5.0655021834061
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
                                    [mfg_barcode] => 8906050590121
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8906050590121
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 40.00
                                )

                        )

                    [id] => 3372
                    [header_id] => 4822
                    [price] => 40.00
                    [name] => AMLA POWDER 100 GM
                    [desc_id] => 3754
                    [description] => 
                    [brand_id] => 75
                    [brand] => BANJARAS
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 378
                    [class] => Powder
                    [details] => []
                    [header_mfg_barcode] => 8906050590121
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 40
                    [stock] => 6.000
                    [mrp_value] => 240.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 40
                )

        )

    [payment] => Array
        (
            [cash] => 40.00
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
                    [amount] => 40.00
                )

        )

    [status] => paid
    [date] => 27-11-2013
    [barcode] => 4060043860
    [print] => 0
)

ERROR - 2013-11-27 10:09:55 --> Bill - Exchange BillArray
(
    [id] => 43859
    [created_at] => 2013-11-27 14:39:32
    [user_id] => 5
    [paid_by_cash] => 40.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 5.07
    [vat_discount] => 0
    [total_amount] => 40.00
    [final_amount] => 40.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 10:09:55 --> Array
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
            [mfg_barcode] => 8906050590121
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906050590121
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 40.00
        )

)

ERROR - 2013-11-27 10:10:02 --> Query error: Unknown column 'bill_id' in 'where clause'
ERROR - 2013-11-27 10:10:02 --> Query error: Unknown column 'bill_id' in 'where clause'
ERROR - 2013-11-27 10:10:35 --> Query error: Unknown column '1' in 'field list'
ERROR - 2013-11-27 10:11:10 --> Query error: Unknown column 'bill_id' in 'where clause'
ERROR - 2013-11-27 10:11:30 --> Severity: Notice  --> Undefined variable: r C:\xampp\htdocs\shringar_live\application\models\bill_model.php 78
ERROR - 2013-11-27 10:11:30 --> Array
(
    [tab] => exchange
    [bill_items] => Array
        (
            [0] => Array
                (
                    [id] => 124302
                    [bill_id] => 43859
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [quantity] => 1.000
                    [weight] => 0.000
                    [price] => 40.00
                    [vat] => 5.066
                    [discount] => 0.000
                    [final_amount] => 40.00
                    [branch_id] => 0
                    [credit_note_id] => 0
                    [returned_qty] => 0.000
                    [exchange] => 0
                )

        )

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

    [selected_products] => Array
        (
            [124302] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [bill_item_id] => 124302
                    [quantity] => 1
                    [weight] => 0
                    [price] => 40.00
                    [name] => AMLA POWDER 100 GM
                    [discount] => 0
                    [vat_percentage] => 14.5
                    [final_amount] => 40
                )

        )

    [total_credit_note] => 40
    [credit_note_id] => 587
    [date] => 2013-11-27 14:41:30
    [barcode] => 4100000587
    [print] => 0
)

ERROR - 2013-11-27 10:29:50 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:30:31 --> TOTAL BILL BACKEND339
ERROR - 2013-11-27 10:30:31 --> TOTAL BILL Frontend0
ERROR - 2013-11-27 10:30:31 --> Array
(
    [bill_id] => 43861
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

    [bill_subtotal] => 339
    [bill_amount] => 339
    [vat_amount] => 42.930131004367
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 7545
                    [row_count] => 2
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 299.00
                    [discount_amount] => 0
                    [price_without_vat] => 261.13537117904
                    [vat_amount] => 37.864628820961
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
                                    [mfg_barcode] => 627762290014
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 627762290014
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 299.00
                                )

                        )

                    [id] => 7545
                    [header_id] => 2008
                    [price] => 299.00
                    [name] => BLACK Liner
                    [desc_id] => 1981
                    [description] => 
                    [brand_id] => 8
                    [brand] => FACES
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 155
                    [class] => Eye Liner
                    [details] => []
                    [header_mfg_barcode] => 627762290014
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 299
                    [stock] => 1.000
                    [mrp_value] => 299.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 299
                )

            [1] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 40.00
                    [discount_amount] => 0
                    [price_without_vat] => 34.934497816594
                    [vat_amount] => 5.0655021834061
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
                                    [mfg_barcode] => 8906050590121
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8906050590121
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 40.00
                                )

                        )

                    [id] => 3372
                    [header_id] => 4822
                    [price] => 40.00
                    [name] => AMLA POWDER 100 GM
                    [desc_id] => 3754
                    [description] => 
                    [brand_id] => 75
                    [brand] => BANJARAS
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 378
                    [class] => Powder
                    [details] => []
                    [header_mfg_barcode] => 8906050590121
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 40
                    [stock] => 6.000
                    [mrp_value] => 240.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 40
                )

        )

    [payment] => Array
        (
            [cash] => 339.00
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
                    [amount] => 339.00
                )

        )

    [status] => paid
    [date] => 27-11-2013
    [barcode] => 4060043861
    [print] => 0
)

ERROR - 2013-11-27 10:30:42 --> Bill - Exchange BillArray
(
    [id] => 43861
    [created_at] => 2013-11-27 15:00:31
    [user_id] => 5
    [paid_by_cash] => 339.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 42.93
    [vat_discount] => 0
    [total_amount] => 339.00
    [final_amount] => 339.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 10:30:42 --> Array
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
            [mfg_barcode] => 627762290014
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 627762290014
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 299.00
        )

)

ERROR - 2013-11-27 10:30:42 --> Array
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
            [mfg_barcode] => 8906050590121
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906050590121
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 40.00
        )

)

ERROR - 2013-11-27 10:30:44 --> Severity: Notice  --> Undefined variable: r C:\xampp\htdocs\shringar_live\application\models\bill_model.php 78
ERROR - 2013-11-27 10:30:45 --> Severity: Notice  --> Undefined variable: output C:\xampp\htdocs\shringar_live\application\views\billing\print_credit_note.php 2
ERROR - 2013-11-27 10:30:45 --> 
ERROR - 2013-11-27 10:30:45 --> #4, po/printpo.php error
ERROR - 2013-11-27 10:31:28 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:31:36 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:32:07 --> Bill - Exchange BillArray
(
    [id] => 43861
    [created_at] => 2013-11-27 15:00:31
    [user_id] => 5
    [paid_by_cash] => 339.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 42.93
    [vat_discount] => 0
    [total_amount] => 339.00
    [final_amount] => 339.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 1
)

ERROR - 2013-11-27 10:32:07 --> Array
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
            [mfg_barcode] => 627762290014
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 627762290014
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 299.00
        )

)

ERROR - 2013-11-27 10:32:26 --> Bill - Exchange BillArray
(
    [id] => 43861
    [created_at] => 2013-11-27 15:00:31
    [user_id] => 5
    [paid_by_cash] => 339.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 42.93
    [vat_discount] => 0
    [total_amount] => 339.00
    [final_amount] => 339.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 1
)

ERROR - 2013-11-27 10:32:26 --> Array
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
            [mfg_barcode] => 627762290014
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 627762290014
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 299.00
        )

)

ERROR - 2013-11-27 10:32:29 --> Array
(
    [tab] => exchange
    [bill_items] => Array
        (
            [0] => Array
                (
                    [id] => 124304
                    [bill_id] => 43861
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 7545
                    [quantity] => 1.000
                    [weight] => 0.000
                    [price] => 299.00
                    [vat] => 37.865
                    [discount] => 0.000
                    [final_amount] => 299.00
                    [branch_id] => 0
                    [credit_note_id] => 0
                    [returned_qty] => 0.000
                    [exchange] => 1
                )

            [1] => Array
                (
                    [id] => 124305
                    [bill_id] => 43861
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [quantity] => 1.000
                    [weight] => 0.000
                    [price] => 40.00
                    [vat] => 5.066
                    [discount] => 0.000
                    [final_amount] => 40.00
                    [branch_id] => 0
                    [credit_note_id] => 0
                    [returned_qty] => 1.000
                    [exchange] => 1
                )

        )

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

    [selected_products] => Array
        (
            [124304] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 7545
                    [bill_item_id] => 124304
                    [quantity] => 1
                    [weight] => 0
                    [price] => 299.00
                    [name] => BLACK Liner
                    [discount] => 0
                    [vat_percentage] => 14.5
                    [final_amount] => 299
                )

        )

    [total_credit_note] => 299
    [credit_note_id] => 590
    [date] => 2013-11-27 15:02:29
    [barcode] => 4100000590
    [print] => 0
)

ERROR - 2013-11-27 10:34:26 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:29 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:29 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:31 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:33 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:33 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:36 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:36 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:38 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:41 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:34:43 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:35:28 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:36:43 --> 404 Page Not Found --> billing/get_bill_items_by_id2
ERROR - 2013-11-27 10:36:45 --> 404 Page Not Found --> billing/get_bill_items_by_id2
ERROR - 2013-11-27 10:36:45 --> 404 Page Not Found --> billing/get_bill_items_by_id2
ERROR - 2013-11-27 10:36:47 --> 404 Page Not Found --> billing/get_bill_items_by_id2
ERROR - 2013-11-27 10:36:53 --> 404 Page Not Found --> billing/get_bill_items_by_id2
ERROR - 2013-11-27 10:37:07 --> 404 Page Not Found --> billing/get_bill_items_by_id2
ERROR - 2013-11-27 10:40:28 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:41:30 --> TOTAL BILL BACKEND339
ERROR - 2013-11-27 10:41:30 --> TOTAL BILL Frontend0
ERROR - 2013-11-27 10:41:31 --> Array
(
    [bill_id] => 43862
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

    [bill_subtotal] => 339
    [bill_amount] => 339
    [vat_amount] => 42.930131004367
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 7545
                    [row_count] => 2
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 299.00
                    [discount_amount] => 0
                    [price_without_vat] => 261.13537117904
                    [vat_amount] => 37.864628820961
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
                                    [mfg_barcode] => 627762290014
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 627762290014
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 299.00
                                )

                        )

                    [id] => 7545
                    [header_id] => 2008
                    [price] => 299.00
                    [name] => BLACK Liner
                    [desc_id] => 1981
                    [description] => 
                    [brand_id] => 8
                    [brand] => FACES
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 155
                    [class] => Eye Liner
                    [details] => []
                    [header_mfg_barcode] => 627762290014
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 299
                    [stock] => 1.000
                    [mrp_value] => 299.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 299
                )

            [1] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 40.00
                    [discount_amount] => 0
                    [price_without_vat] => 34.934497816594
                    [vat_amount] => 5.0655021834061
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
                                    [mfg_barcode] => 8906050590121
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8906050590121
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 40.00
                                )

                        )

                    [id] => 3372
                    [header_id] => 4822
                    [price] => 40.00
                    [name] => AMLA POWDER 100 GM
                    [desc_id] => 3754
                    [description] => 
                    [brand_id] => 75
                    [brand] => BANJARAS
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 378
                    [class] => Powder
                    [details] => []
                    [header_mfg_barcode] => 8906050590121
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 40
                    [stock] => 6.000
                    [mrp_value] => 240.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 40
                )

        )

    [payment] => Array
        (
            [cash] => 339.00
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
                    [amount] => 339.00
                )

        )

    [status] => paid
    [date] => 27-11-2013
    [barcode] => 4060043862
    [print] => 0
)

ERROR - 2013-11-27 10:41:41 --> Bill - Exchange BillArray
(
    [id] => 43862
    [created_at] => 2013-11-27 15:11:30
    [user_id] => 5
    [paid_by_cash] => 339.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 42.93
    [vat_discount] => 0
    [total_amount] => 339.00
    [final_amount] => 339.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 10:41:41 --> Array
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
            [mfg_barcode] => 627762290014
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 627762290014
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 299.00
        )

)

ERROR - 2013-11-27 10:41:41 --> Array
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
            [mfg_barcode] => 8906050590121
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906050590121
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 40.00
        )

)

ERROR - 2013-11-27 10:41:45 --> Severity: Notice  --> Undefined variable: r C:\xampp\htdocs\shringar_live\application\models\bill_model.php 78
ERROR - 2013-11-27 10:41:45 --> Severity: Notice  --> Undefined variable: output C:\xampp\htdocs\shringar_live\application\views\billing\print_credit_note.php 2
ERROR - 2013-11-27 10:41:45 --> 
ERROR - 2013-11-27 10:41:45 --> #4, po/printpo.php error
ERROR - 2013-11-27 10:42:50 --> Severity: Notice  --> Undefined variable: output C:\xampp\htdocs\shringar_live\application\views\billing\print_credit_note.php 2
ERROR - 2013-11-27 10:42:50 --> 
ERROR - 2013-11-27 10:42:50 --> #4, po/printpo.php error
ERROR - 2013-11-27 10:42:52 --> Severity: Notice  --> Undefined variable: output C:\xampp\htdocs\shringar_live\application\views\billing\print_credit_note.php 2
ERROR - 2013-11-27 10:42:52 --> 
ERROR - 2013-11-27 10:42:52 --> #4, po/printpo.php error
ERROR - 2013-11-27 10:43:02 --> Bill - Exchange BillArray
(
    [id] => 43862
    [created_at] => 2013-11-27 15:11:30
    [user_id] => 5
    [paid_by_cash] => 339.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 42.93
    [vat_discount] => 0
    [total_amount] => 339.00
    [final_amount] => 339.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 1
)

ERROR - 2013-11-27 10:43:02 --> Array
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
            [mfg_barcode] => 627762290014
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 627762290014
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 299.00
        )

)

ERROR - 2013-11-27 10:43:39 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 13
ERROR - 2013-11-27 10:44:43 --> Bill - Exchange BillArray
(
    [id] => 43861
    [created_at] => 2013-11-27 15:00:31
    [user_id] => 5
    [paid_by_cash] => 339.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 42.93
    [vat_discount] => 0
    [total_amount] => 339.00
    [final_amount] => 339.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 1
)

ERROR - 2013-11-27 10:44:46 --> Bill - Exchange BillArray
(
    [id] => 43862
    [created_at] => 2013-11-27 15:11:30
    [user_id] => 5
    [paid_by_cash] => 339.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 42.93
    [vat_discount] => 0
    [total_amount] => 339.00
    [final_amount] => 339.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 1
)

ERROR - 2013-11-27 10:44:46 --> Array
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
            [mfg_barcode] => 627762290014
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 627762290014
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 299.00
        )

)

ERROR - 2013-11-27 10:44:53 --> Bill - Exchange BillArray
(
    [id] => 43860
    [created_at] => 2013-11-27 14:39:32
    [user_id] => 5
    [paid_by_cash] => 40.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 5.07
    [vat_discount] => 0
    [total_amount] => 40.00
    [final_amount] => 40.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 10:44:53 --> Array
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
            [mfg_barcode] => 8906050590121
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906050590121
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 40.00
        )

)

ERROR - 2013-11-27 10:45:02 --> Bill - Exchange BillArray
(
    [id] => 43860
    [created_at] => 2013-11-27 14:39:32
    [user_id] => 5
    [paid_by_cash] => 40.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 5.07
    [vat_discount] => 0
    [total_amount] => 40.00
    [final_amount] => 40.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 0
)

ERROR - 2013-11-27 10:45:02 --> Array
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
            [mfg_barcode] => 8906050590121
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8906050590121
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 40.00
        )

)

ERROR - 2013-11-27 10:45:04 --> Severity: Notice  --> Undefined variable: r C:\xampp\htdocs\shringar_live\application\models\bill_model.php 78
ERROR - 2013-11-27 10:45:04 --> Array
(
    [tab] => exchange
    [bill_items] => Array
        (
            [0] => Array
                (
                    [id] => 124303
                    [bill_id] => 43860
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [quantity] => 1.000
                    [weight] => 0.000
                    [price] => 40.00
                    [vat] => 5.066
                    [discount] => 0.000
                    [final_amount] => 40.00
                    [branch_id] => 0
                    [credit_note_id] => 0
                    [returned_qty] => 0.000
                    [exchange] => 0
                )

        )

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

    [selected_products] => Array
        (
            [124303] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [bill_item_id] => 124303
                    [quantity] => 1
                    [weight] => 0
                    [price] => 40.00
                    [name] => AMLA POWDER 100 GM
                    [discount] => 0
                    [vat_percentage] => 14.5
                    [final_amount] => 40
                )

        )

    [total_credit_note] => 40
    [credit_note_id] => 593
    [date] => 2013-11-27 15:15:04
    [barcode] => 4100000593
    [print] => 0
)

ERROR - 2013-11-27 11:49:47 --> Array
(
    [tab] => exchange
    [bill_items] => Array
        (
            [0] => Array
                (
                    [id] => 124303
                    [bill_id] => 43860
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [quantity] => 1.000
                    [weight] => 0.000
                    [price] => 40.00
                    [vat] => 5.066
                    [discount] => 0.000
                    [final_amount] => 40.00
                    [branch_id] => 0
                    [credit_note_id] => 0
                    [returned_qty] => 0.000
                    [exchange] => 0
                )

        )

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

    [selected_products] => Array
        (
            [124303] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3372
                    [bill_item_id] => 124303
                    [quantity] => 1
                    [weight] => 0
                    [price] => 40.00
                    [name] => AMLA POWDER 100 GM
                    [discount] => 0
                    [vat_percentage] => 14.5
                    [final_amount] => 40
                )

        )

    [total_credit_note] => 40
    [credit_note_id] => 593
    [date] => 2013-11-27 15:15:04
    [barcode] => 4100000593
    [print] => 0
)

ERROR - 2013-11-27 11:50:01 --> Bill - Exchange BillArray
(
    [id] => 43862
    [created_at] => 2013-11-27 15:11:30
    [user_id] => 5
    [paid_by_cash] => 339.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 42.93
    [vat_discount] => 0
    [total_amount] => 339.00
    [final_amount] => 339.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 1
)

ERROR - 2013-11-27 11:50:01 --> Array
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
            [mfg_barcode] => 627762290014
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 627762290014
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 299.00
        )

)

ERROR - 2013-11-27 11:59:32 --> Bill - Exchange BillArray
(
    [id] => 43862
    [created_at] => 2013-11-27 15:11:30
    [user_id] => 5
    [paid_by_cash] => 339.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 42.93
    [vat_discount] => 0
    [total_amount] => 339.00
    [final_amount] => 339.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
    [exchange] => 1
)

ERROR - 2013-11-27 11:59:32 --> Array
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
            [mfg_barcode] => 627762290014
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 627762290014
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 299.00
        )

)

ERROR - 2013-11-27 12:23:14 --> Severity: Notice  --> Undefined variable: returned_qty C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 16
ERROR - 2013-11-27 12:23:14 --> Severity: Notice  --> Undefined variable: quantity C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 16
ERROR - 2013-11-27 12:23:14 --> Severity: Notice  --> Undefined variable: returned_qty C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 16
ERROR - 2013-11-27 12:23:14 --> Severity: Notice  --> Undefined variable: quantity C:\xampp\htdocs\shringar_live\application\views\billing\view_bill_items.php 16
