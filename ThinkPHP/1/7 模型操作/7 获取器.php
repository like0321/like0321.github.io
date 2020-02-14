<?php





    二、获取器

        对模型实例的(原始)数据做出自动处理。

                        get字段名Attr  如果有下划线，下划线后的首字母大写
        public function getCreateTimeAttr($value)
        {
            return date('Y年m月d日 H时i分s秒', strtotime($value));
        }

























