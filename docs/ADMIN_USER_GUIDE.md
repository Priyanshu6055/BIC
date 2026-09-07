# BIC admin user guide

## Login

Open `/admin/login` and sign in with an administrator account created through `php artisan bic:admin-create`. Admin pages are excluded from public indexing.

## Inquiries

Open **Inquiries** to see reference, date, type, name, email, phone, company and status. Filter by type or status, then choose **View** for every submitted field. Change status to New, Reviewed, Contacted, Closed or Spam and select **Update**. If a PDF was provided, **Download PDF** streams it only after admin authorization; never share the authenticated URL.

## Insights

Open **Insights**, choose **New Insight**, and enter title, summary and body. Slug may be supplied or generated from the title. Add category, author, alt text, optional cover image and SEO fields.

- **draft** saves privately.
- **published** becomes public when its publish time is due.
- **archived** removes it from public pages without deleting it.

Use **Featured** where appropriate. The homepage always selects the latest three published Insights. To unpublish, edit an Insight and change status to draft or archived.

## Security

Use an individual admin account and a unique password of at least 12 characters. Log out on shared computers. Do not send uploaded inquiry documents by open link; download them only when required and handle them confidentially.

