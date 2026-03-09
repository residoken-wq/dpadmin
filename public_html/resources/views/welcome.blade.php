
SELECT * FROM `DT_Order_Supplier` WHERE tong >0 AND phidichthuat > 0
UPDATE `DT_Order_Supplier` SET tong = tong - phidichthuat WHERE tong >0 AND phidichthuat > 0


