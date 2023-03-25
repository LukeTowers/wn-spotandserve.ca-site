<div class="form-buttons">
    <div class="loading-indicator-container" style="text-align: center;">
        <button
            type="submit"
            data-request="onMarkSuccessful"
            data-hotkey="ctrl+s, cmd+s"
            style="margin-bottom: 2em; vertical-align: top"
            data-load-indicator="Finalizing report..."
            class="btn btn-primary oc-icon-check">
            Mark <u>S</u>uccessful
        </button>
        <button
            type="submit"
            data-request="onMarkUnsuccessful"
            style="vertical-align: top;"
            data-request-confirm="Are you sure you want to mark this request as unsuccessful? If contact information was provided try contacting the submitter to ask for more details. Press OK if you would like to continue marking this request unsuccessful or Cancel if you are going to leave it for now."
            data-hotkey="ctrl+u, cmd+u"
            data-load-indicator="Finalizing report..."
            class="btn btn-danger oc-icon-times">
            Mark <u>U</u>nsuccessful
        </button>
    </div>
</div>
