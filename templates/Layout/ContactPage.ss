<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
		
        <% if Success %>
           $OnSubmissionContent
        <% else %>  
        
           $Form
           
           <div id="contactResponse">
               $OnSubmissionContent
           </div>
           
        <% end_if %>
		
	</article>

</div>