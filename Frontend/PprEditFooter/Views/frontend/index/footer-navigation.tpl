{extends file="parent:frontend/index/footer-navigation.tpl"}
{block name="frontend_index_footer_column_service_hotline"}
		{if $show1}
	    <div class="footer--column column--hotline is--first block">
					{$column1}
			
			

		</div>
		{else}
			{$smarty.block.parent}
		{/if}
{/block}

{block name="frontend_index_footer_column_service_menu"}
		{if $show2}
	    <div class="footer--column column--menu block">
			<div class="column--headline">{$heading2}</div>

				<div class="column--content">
					{$column2}
				</div>
		</div>
		{else}
			{$smarty.block.parent}
		{/if}

{/block}
{block name="frontend_index_footer_column_information_menu"}
		{if $show3}
	    <div class="footer--column column--information block">
			<div class="column--headline">{$heading3}</div>

				<div class="column--content">
					{$column3}
				</div>
		</div>
		{else}
			{$smarty.block.parent}
		{/if}
{/block}

{block name="frontend_index_footer_column_newsletter"}
		{if $show4}
	    <div class="footer--column column--newsletter block">
			<div class="column--headline">{$heading4}</div>

				<div class="column--content">
					{$column4}
				</div>
		</div>
		{else}
			{$smarty.block.parent}
		{/if}
{/block}
