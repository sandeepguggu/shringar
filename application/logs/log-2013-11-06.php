<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2013-11-06 11:17:16 --> TOTAL BILL BACKEND216
ERROR - 2013-11-06 11:17:16 --> TOTAL BILL Frontend0
ERROR - 2013-11-06 11:17:17 --> Array
(
    [bill_id] => 43850
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

    [bill_subtotal] => 216
    [bill_amount] => 216
    [vat_amount] => 27.353711790393
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 20824
                    [row_count] => 2
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 100.00
                    [discount_amount] => 0
                    [price_without_vat] => 87.336244541485
                    [vat_amount] => 12.663755458515
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
                                    [mfg_barcode] => 8901030403606
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901030403606
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 100.00
                                )

                        )

                    [id] => 20824
                    [header_id] => 4337
                    [price] => 100.00
                    [name] => LAKME ABSOLUTE COMPACT PUFF 1 PC
                    [desc_id] => 4092
                    [description] => 
                    [brand_id] => 1
                    [brand] => LAKME
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 551
                    [class] => PUFF
                    [details] => []
                    [header_mfg_barcode] => 8901030403606
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 100
                    [stock] => 1.000
                    [mrp_value] => 100.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 100
                )

            [1] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3790
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 2
                    [price_initial] => 58.00
                    [discount_amount] => 0
                    [price_without_vat] => 50.655021834061
                    [vat_amount] => 14.689956331878
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
                                    [mfg_barcode] => 8901012153062
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901012153062
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 58.00
                                )

                        )

                    [id] => 3790
                    [header_id] => 5206
                    [price] => 58.00
                    [name] => PRICKLY HEAT POWDER COLOGNE COOL TALC 150 GM
                    [desc_id] => 4946
                    [description] => 
                    [brand_id] => 102
                    [brand] => SHOWER TO SHOWER
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 378
                    [class] => Powder
                    [details] => []
                    [header_mfg_barcode] => 8901012153062
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 58
                    [stock] => 2.000
                    [mrp_value] => 116.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 116
                )

        )

    [payment] => Array
        (
            [cash] => 216.00
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
                    [amount] => 216.00
                )

        )

    [status] => paid
    [date] => 06-11-2013
    [barcode] => 4060043850
    [print] => 0
)

ERROR - 2013-11-06 11:19:42 --> Bill - Exchange BillArray
(
    [id] => 43850
    [created_at] => 2013-11-06 15:47:16
    [user_id] => 5
    [paid_by_cash] => 216.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 27.35
    [vat_discount] => 0
    [total_amount] => 216.00
    [final_amount] => 216.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-06 11:19:42 --> Array
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
            [mfg_barcode] => 8901030403606
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8901030403606
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 100.00
        )

)

ERROR - 2013-11-06 11:19:42 --> Array
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
            [mfg_barcode] => 8901012153062
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8901012153062
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 58.00
        )

)

ERROR - 2013-11-06 11:20:39 --> Array
(
    [tab] => exchange
    [bill_items] => Array
        (
            [0] => Array
                (
                    [id] => 124293
                    [bill_id] => 43850
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 20824
                    [quantity] => 1.000
                    [weight] => 0.000
                    [price] => 100.00
                    [vat] => 12.664
                    [discount] => 0.000
                    [final_amount] => 100.00
                    [branch_id] => 0
                    [credit_note_id] => 0
                    [returned_qty] => 0.000
                )

            [1] => Array
                (
                    [id] => 124294
                    [bill_id] => 43850
                    [product_id] => 0
                    [item_entity_id] => 26
                    [item_specific_id] => 3790
                    [quantity] => 2.000
                    [weight] => 0.000
                    [price] => 58.00
                    [vat] => 14.690
                    [discount] => 0.000
                    [final_amount] => 116.00
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
            [124294] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3790
                    [bill_item_id] => 124294
                    [quantity] => 2
                    [weight] => 0
                    [price] => 58.00
                    [name] => PRICKLY HEAT POWDER COLOGNE COOL TALC 150 GM
                    [discount] => 0
                    [vat_percentage] => 14.5
                    [final_amount] => 116
                )

        )

    [total_credit_note] => 116
    [credit_note_id] => 573
    [date] => 2013-11-06 15:50:38
    [barcode] => 4100000573
    [print] => 0
)

ERROR - 2013-11-06 11:21:14 --> Bill - Exchange BillArray
(
    [id] => 43850
    [created_at] => 2013-11-06 15:47:16
    [user_id] => 5
    [paid_by_cash] => 216.00
    [paid_by_card] => 0.00
    [customer_id] => 1
    [discount_type] => percentage
    [discount_value] => 0.00
    [vat_amount] => 27.35
    [vat_discount] => 0
    [total_amount] => 216.00
    [final_amount] => 216.00
    [paid_by_scheme] => 0.00
    [scheme_user_id] => 0
    [paid_by_old_purchase_bill] => 0.00
    [old_purchase_bill_id] => 
    [paid_by_loyalty_amount] => 0.00
    [status] => paid
    [full_json] => 
)

ERROR - 2013-11-06 11:21:14 --> Array
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
            [mfg_barcode] => 8901030403606
            [name] => mfg_barcode
            [display_name] => Mfg. Barcode
            [level] => 1
            [id] => 13
            [value] => 8901030403606
        )

    [2] => Array
        (
            [id] => 9
            [name] => price
            [display_name] => MRP
            [level] => 1
            [sku] => 0
            [value] => 100.00
        )

)

ERROR - 2013-11-06 11:21:57 --> Array
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

ERROR - 2013-11-06 11:22:39 --> Array
(
    [bill_id] => 43850
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

    [bill_subtotal] => 216
    [bill_amount] => 216
    [vat_amount] => 27.353711790393
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 20824
                    [row_count] => 2
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 100.00
                    [discount_amount] => 0
                    [price_without_vat] => 87.336244541485
                    [vat_amount] => 12.663755458515
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
                                    [mfg_barcode] => 8901030403606
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901030403606
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 100.00
                                )

                        )

                    [id] => 20824
                    [header_id] => 4337
                    [price] => 100.00
                    [name] => LAKME ABSOLUTE COMPACT PUFF 1 PC
                    [desc_id] => 4092
                    [description] => 
                    [brand_id] => 1
                    [brand] => LAKME
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 551
                    [class] => PUFF
                    [details] => []
                    [header_mfg_barcode] => 8901030403606
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 100
                    [stock] => 1.000
                    [mrp_value] => 100.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 100
                )

            [1] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3790
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 2
                    [price_initial] => 58.00
                    [discount_amount] => 0
                    [price_without_vat] => 50.655021834061
                    [vat_amount] => 14.689956331878
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
                                    [mfg_barcode] => 8901012153062
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901012153062
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 58.00
                                )

                        )

                    [id] => 3790
                    [header_id] => 5206
                    [price] => 58.00
                    [name] => PRICKLY HEAT POWDER COLOGNE COOL TALC 150 GM
                    [desc_id] => 4946
                    [description] => 
                    [brand_id] => 102
                    [brand] => SHOWER TO SHOWER
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 378
                    [class] => Powder
                    [details] => []
                    [header_mfg_barcode] => 8901012153062
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 58
                    [stock] => 2.000
                    [mrp_value] => 116.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 116
                )

        )

    [payment] => Array
        (
            [cash] => 216.00
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
                    [amount] => 216.00
                )

        )

    [status] => paid
    [date] => 06-11-2013
    [barcode] => 4060043850
    [print] => 0
)

ERROR - 2013-11-06 11:23:12 --> Array
(
    [bill_id] => 43850
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

    [bill_subtotal] => 216
    [bill_amount] => 216
    [vat_amount] => 27.353711790393
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 20824
                    [row_count] => 2
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 100.00
                    [discount_amount] => 0
                    [price_without_vat] => 87.336244541485
                    [vat_amount] => 12.663755458515
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
                                    [mfg_barcode] => 8901030403606
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901030403606
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 100.00
                                )

                        )

                    [id] => 20824
                    [header_id] => 4337
                    [price] => 100.00
                    [name] => LAKME ABSOLUTE COMPACT PUFF 1 PC
                    [desc_id] => 4092
                    [description] => 
                    [brand_id] => 1
                    [brand] => LAKME
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 551
                    [class] => PUFF
                    [details] => []
                    [header_mfg_barcode] => 8901030403606
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 100
                    [stock] => 1.000
                    [mrp_value] => 100.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 100
                )

            [1] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3790
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 2
                    [price_initial] => 58.00
                    [discount_amount] => 0
                    [price_without_vat] => 50.655021834061
                    [vat_amount] => 14.689956331878
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
                                    [mfg_barcode] => 8901012153062
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901012153062
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 58.00
                                )

                        )

                    [id] => 3790
                    [header_id] => 5206
                    [price] => 58.00
                    [name] => PRICKLY HEAT POWDER COLOGNE COOL TALC 150 GM
                    [desc_id] => 4946
                    [description] => 
                    [brand_id] => 102
                    [brand] => SHOWER TO SHOWER
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 378
                    [class] => Powder
                    [details] => []
                    [header_mfg_barcode] => 8901012153062
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 58
                    [stock] => 2.000
                    [mrp_value] => 116.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 116
                )

        )

    [payment] => Array
        (
            [cash] => 216.00
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
                    [amount] => 216.00
                )

        )

    [status] => paid
    [date] => 06-11-2013
    [barcode] => 4060043850
    [print] => 0
)

ERROR - 2013-11-06 11:23:26 --> Array
(
    [bill_id] => 43850
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

    [bill_subtotal] => 216
    [bill_amount] => 216
    [vat_amount] => 27.353711790393
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 20824
                    [row_count] => 2
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 100.00
                    [discount_amount] => 0
                    [price_without_vat] => 87.336244541485
                    [vat_amount] => 12.663755458515
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
                                    [mfg_barcode] => 8901030403606
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901030403606
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 100.00
                                )

                        )

                    [id] => 20824
                    [header_id] => 4337
                    [price] => 100.00
                    [name] => LAKME ABSOLUTE COMPACT PUFF 1 PC
                    [desc_id] => 4092
                    [description] => 
                    [brand_id] => 1
                    [brand] => LAKME
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 551
                    [class] => PUFF
                    [details] => []
                    [header_mfg_barcode] => 8901030403606
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 100
                    [stock] => 1.000
                    [mrp_value] => 100.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 100
                )

            [1] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3790
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 2
                    [price_initial] => 58.00
                    [discount_amount] => 0
                    [price_without_vat] => 50.655021834061
                    [vat_amount] => 14.689956331878
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
                                    [mfg_barcode] => 8901012153062
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901012153062
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 58.00
                                )

                        )

                    [id] => 3790
                    [header_id] => 5206
                    [price] => 58.00
                    [name] => PRICKLY HEAT POWDER COLOGNE COOL TALC 150 GM
                    [desc_id] => 4946
                    [description] => 
                    [brand_id] => 102
                    [brand] => SHOWER TO SHOWER
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 378
                    [class] => Powder
                    [details] => []
                    [header_mfg_barcode] => 8901012153062
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 58
                    [stock] => 2.000
                    [mrp_value] => 116.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 116
                )

        )

    [payment] => Array
        (
            [cash] => 216.00
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
                    [amount] => 216.00
                )

        )

    [status] => paid
    [date] => 06-11-2013
    [barcode] => 4060043850
    [print] => 0
)

ERROR - 2013-11-06 11:23:44 --> Array
(
    [bill_id] => 43850
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

    [bill_subtotal] => 216
    [bill_amount] => 216
    [vat_amount] => 27.353711790393
    [discount] => 0
    [products] => Array
        (
            [0] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 20824
                    [row_count] => 2
                    [discount] => 0
                    [quantity] => 1
                    [price_initial] => 100.00
                    [discount_amount] => 0
                    [price_without_vat] => 87.336244541485
                    [vat_amount] => 12.663755458515
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
                                    [mfg_barcode] => 8901030403606
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901030403606
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 100.00
                                )

                        )

                    [id] => 20824
                    [header_id] => 4337
                    [price] => 100.00
                    [name] => LAKME ABSOLUTE COMPACT PUFF 1 PC
                    [desc_id] => 4092
                    [description] => 
                    [brand_id] => 1
                    [brand] => LAKME
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 551
                    [class] => PUFF
                    [details] => []
                    [header_mfg_barcode] => 8901030403606
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 100
                    [stock] => 1.000
                    [mrp_value] => 100.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 100
                )

            [1] => Array
                (
                    [item_entity_id] => 26
                    [item_specific_id] => 3790
                    [row_count] => 1
                    [discount] => 0
                    [quantity] => 2
                    [price_initial] => 58.00
                    [discount_amount] => 0
                    [price_without_vat] => 50.655021834061
                    [vat_amount] => 14.689956331878
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
                                    [mfg_barcode] => 8901012153062
                                    [name] => mfg_barcode
                                    [display_name] => Mfg. Barcode
                                    [level] => 1
                                    [id] => 13
                                    [value] => 8901012153062
                                )

                            [2] => Array
                                (
                                    [id] => 9
                                    [name] => price
                                    [display_name] => MRP
                                    [level] => 1
                                    [sku] => 0
                                    [value] => 58.00
                                )

                        )

                    [id] => 3790
                    [header_id] => 5206
                    [price] => 58.00
                    [name] => PRICKLY HEAT POWDER COLOGNE COOL TALC 150 GM
                    [desc_id] => 4946
                    [description] => 
                    [brand_id] => 102
                    [brand] => SHOWER TO SHOWER
                    [tax_category] => COSMETICS 14.5
                    [category_id] => 20
                    [vat_percentage] => 14.5
                    [class_id] => 378
                    [class] => Powder
                    [details] => []
                    [header_mfg_barcode] => 8901012153062
                    [model_name] => product_sku
                    [items] => Array
                        (
                        )

                    [rate] => 58
                    [stock] => 2.000
                    [mrp_value] => 116.00000
                    [category_name] => COSMETICS 14.5
                    [final_amount] => 116
                )

        )

    [payment] => Array
        (
            [cash] => 216.00
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
                    [amount] => 216.00
                )

        )

    [status] => paid
    [date] => 06-11-2013
    [barcode] => 4060043850
    [print] => 0
)

