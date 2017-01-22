<template>
    <div class="container">

        <h1 class="title is-2 has-text-centered">
            Dashboard Home
        </h1>
        <div class="columns">
            <div class="column is-full-mobile is-offset-2-desktop is-8-desktop">
                <p class="m-b-s">
                    Welcome to your lightweight blog engine.
                </p>
                <p class="m-b-s">
                    There are <strong>2</strong> types of posts:<br>
                    <strong>Blog posts </strong>(articles) and <strong>projects</strong>
                    (a portfolio post type),
                    which in front-end are displayed differently. To mark a post as project simply add an
                    <span class="tag is-primary">is-project</span> tag.<br>
                    Both projects and posts are using
                    <a href="https://guides.github.com/features/mastering-markdown/" target="_blank" title="Learn to use Markdown">
                        Markdown</a> format.
                </p>
                <p>
                    • <strong>To create a new post</strong> click "New" from the left side menu.
                </p>
                <p  class="m-t-s">
                    • <strong>To browse - search - edit - delete posts or projects</strong>, click on the respective link from the left
                    side of the menu.
                </p>
                <p class="m-t-s">
                    • <strong>To upload - delete file(s)</strong> click "Files" from the left side bar menu.
                </p>
                <p class="m-t-s">
                    • <strong>To edit your personal details</strong> click "Security"
                </p>
                <p class="m-t-s">
                    • The 'Integrations' section is where you can enable Google Analytics and Disqus comments for your blog posts.
                </p>
                <h3 class="title is-3 primary has-text-centered">Caution</h3>
                <p>
                    All destractive functions such as posts, projects and file deletions
                    <strong>do not ask for confirmation</strong>, please be careful!
                </p>
            </div>
        </div>

    </div>
</template>

<script>
  export default {}
</script>
