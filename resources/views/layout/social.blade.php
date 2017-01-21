<div class="social-shares">

    <ul>
        <a href="http://www.facebook.com/share.php?u=@php echo urlencode(Request::fullUrl()); @endphp" title="share on Facebook"
           class="social-share" target="_blank">
            <li>
            <span class="icon is-medium">
                <i class="fa fa-facebook"></i>
            </span>
            </li>
        </a>
        <a href="https://twitter.com/intent/tweet/?url=@php echo urlencode(Request::fullUrl()); @endphp"
           title="share on Twitter" class="social-share" target="_blank">
            <li>
                <span class="icon is-medium">
                    <i class="fa fa-twitter"></i>
                </span>
            </li>
        </a>

        <a href="https://www.reddit.com/submit/?url=@php echo urlencode(Request::fullUrl()); @endphp"
           title="share on Reddit" class="social-share" target="_blank" data-width="600" data-height="400">
            <li>
                <span class="icon is-medium">
                    <i class="fa fa-reddit"></i>
                </span>
            </li>
        </a>
    </ul>

</div>
