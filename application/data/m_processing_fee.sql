ALTER TABLE `vs_processing_fee`  ADD `evisa_tourist_1ms_urgent` DOUBLE NOT NULL DEFAULT '19'  AFTER `capital_business_1ym_holiday`,  ADD `evisa_tourist_1ms_emergency` DOUBLE NOT NULL DEFAULT '49'  AFTER `evisa_tourist_1ms_urgent`,  ADD `evisa_tourist_1ms_holiday` DOUBLE NOT NULL DEFAULT '149'  AFTER `evisa_tourist_1ms_emergency`,  ADD `evisa_business_1ms_urgent` DOUBLE NOT NULL DEFAULT '19'  AFTER `evisa_tourist_1ms_holiday`,  ADD `evisa_business_1ms_emergency` DOUBLE NOT NULL DEFAULT '49'  AFTER `evisa_business_1ms_urgent`,  ADD `evisa_business_1ms_holiday` DOUBLE NOT NULL DEFAULT '149'  AFTER `evisa_business_1ms_emergency`,  ADD `capital_evisa_tourist_1ms_urgent` DOUBLE NOT NULL DEFAULT '0'  AFTER `evisa_business_1ms_holiday`,  ADD `capital_evisa_tourist_1ms_emergency` DOUBLE NOT NULL DEFAULT '0'  AFTER `capital_evisa_tourist_1ms_urgent`,  ADD `capital_evisa_tourist_1ms_holiday` DOUBLE NOT NULL DEFAULT '0'  AFTER `capital_evisa_tourist_1ms_emergency`,  ADD `capital_evisa_business_1ms_urgent` DOUBLE NOT NULL DEFAULT '0'  AFTER `capital_evisa_tourist_1ms_holiday`,  ADD `capital_evisa_business_1ms_emergency` DOUBLE NOT NULL DEFAULT '0'  AFTER `capital_evisa_business_1ms_urgent`,  ADD `capital_evisa_business_1ms_holiday` DOUBLE NOT NULL DEFAULT '0'  AFTER `capital_evisa_business_1ms_emergency`;