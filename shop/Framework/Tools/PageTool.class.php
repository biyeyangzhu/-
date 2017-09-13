<?php

/**
 * 分页工具条
 */
class PageTool
{
    /**
     * 生成工具条代码
     * @param $count 总条数
     * @param $pageSize 每页显示条数
     * @param $page 当前页
     * @param $url 链接
     */
    public static function show($count,$pageSize,$page,$url){

        //计算总页数
        $total = ceil(($count/$pageSize));
        //上一页
        $pre_page = ($page-1) < 1 ? 1:($page-1);
        //下一页
        $next_page = ($page+1) > $total ? $total:($page+1);

        //字符表达形式
        $html = <<<HTML
          <table id="page-table" cellspacing="0">
                <tbody>
                    <tr>
                        <td align="right" nowrap="true" style="background-color: rgb(255, 255, 255);">
                            <div id="turn-page">
                                总计  <span id="totalRecords">{$count}</span>个记录分为 <span id="totalPages">{$total}</span>页当前第 <span id="pageCurrent">{$page}</span>
                                页，每页 <input type="text" size="3" id="pageSize" value="{$pageSize}" onkeypress="return listTable.changePageSize(event)">
                                <span id="page-link">
                                    <a href="{$url}&page=1">第一页</a>
                                    <a href="{$url}&page={$pre_page}">上一页</a>
                                    <a href="{$url}&page={$next_page}">下一页</a>
                                    <a href="{$url}&page={$total}">最末页</a>
                                </span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

HTML;
        return $html;
    }
}