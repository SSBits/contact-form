<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
	</article>
	
	<% if Success %>
	   $OnSubmissionContent
	<% else %>	
	   $ContactForm
    <% end_if %>
    
</div>