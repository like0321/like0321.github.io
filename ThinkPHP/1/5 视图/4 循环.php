<?php



	一、循环标签

    
    1、foreach 【推荐】

        {foreach $list as $key=>$vo}

            {$vo.id} : {$vo.name}

        {/foreach}


    
    2、volist

        {volist name="list" id="vo"}

            {$vo.id} : {$vo.name}

        {/volist}
