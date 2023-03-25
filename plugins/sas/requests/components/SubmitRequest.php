<?php

namespace SAS\Requests\Components;

use Auth;
use Backend;
use Backend\Classes\WidgetManager;
use Backend\Models\UserRole;
use Cms\Classes\ComponentBase;
use DB;
use Flash;
use Mail;
use Redirect;

class SubmitRequest extends ComponentBase
{
    use \Backend\Traits\FormModelSaver;

    /**
     * @var Controller The form controller instance
     */
    protected $formController;

    public function componentDetails()
    {
        return [
            'name'        => 'Submit Request',
            'description' => 'Form for submitting requestsa'
        ];
    }

    public function init()
    {
        $this->initFormController();
    }

    public function initFormController()
    {
        if ($this->formController) {
            return;
        }

        // Register the form widgets:
        WidgetManager::instance()->registerFormWidgets(function ($manager) {
            $manager->registerFormWidget(\Backend\FormWidgets\CodeEditor::class, 'codeeditor');
            $manager->registerFormWidget(\Backend\FormWidgets\RichEditor::class, 'richeditor');
            $manager->registerFormWidget(\Backend\FormWidgets\MarkdownEditor::class, 'markdown');
            $manager->registerFormWidget(\Backend\FormWidgets\FileUpload::class, 'fileupload');
            $manager->registerFormWidget(\Backend\FormWidgets\Relation::class, 'relation');
            $manager->registerFormWidget(\Backend\FormWidgets\DatePicker::class, 'datepicker');
            $manager->registerFormWidget(\Backend\FormWidgets\TimePicker::class, 'timepicker');
            $manager->registerFormWidget(\Backend\FormWidgets\ColorPicker::class, 'colorpicker');
            $manager->registerFormWidget(\Backend\FormWidgets\DataTable::class, 'datatable');
            $manager->registerFormWidget(\Backend\FormWidgets\RecordFinder::class, 'recordfinder');
            $manager->registerFormWidget(\Backend\FormWidgets\Repeater::class, 'repeater');
            $manager->registerFormWidget(\Backend\FormWidgets\TagList::class, 'taglist');
            $manager->registerFormWidget(\Backend\FormWidgets\MediaFinder::class, 'mediafinder');
            $manager->registerFormWidget(\Backend\FormWidgets\NestedForm::class, 'nestedform');
        });

        // Initialize the Request model
        $model = new \SAS\Requests\Models\Request;

        // Build a backend form with the context of 'frontend'
        $formController = new \SAS\Requests\Controllers\Requests();
        $formController->initForm($model, 'frontend');
        $formController->create('frontend');

        $this->formController = $this->page['form'] = $formController;

        $aliasesToProxy = array_keys(get_object_vars($this->formController->widget));

        $this->controller->bindEvent('ajax.beforeRunHandler', function ($handler) use ($aliasesToProxy) {
            if (strpos($handler, '::')) {
                list($componentAlias, $handlerName) = explode('::', $handler);

                if (in_array($componentAlias, $aliasesToProxy)) {
                    return $this->formController->runAjaxHandler($handler);
                }
            }
        });
    }

    public function onRun()
    {
        // Load the required assets
        $this->addJs('/modules/system/assets/ui/storm-min.js', 'core');
        $this->addJs('/modules/backend/assets/js/winter-min.js', 'core');
        $this->addJs('/modules/system/assets/js/lang/lang.en.js', 'core'); // required for datepicker

        $this->addCss('/plugins/sas/requests/assets/css/submitrequest.css');

        foreach ($this->formController->getAssetPaths() as $type => $assets) {
            foreach ($assets as $asset){
                $this->{'add' . ucfirst($type)}($asset);
            }
        }
    }

    public function onSave()
    {
        $this->initFormController();

        $model = $this->formController->formGetModel();
        $form  = $this->formController->formGetWidget();
        $formData = $form->getSaveData();

        // Attach the current user if present
        if (Auth::check()) {
            $formData['submitted_by'] = Auth::getUser()->id;
        }

        // Save the request
        $modelsToSave = $this->prepareModelsToSave(
            $model,
            $formData
        );
        DB::transaction(function () use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->save(null, $this->formController->formGetSessionKey());
            }
        });

        $vars = [
            'submitted_address' => @$model->data['addressfinder'],
            'address'           => $model->address,
            'city'              => $model->city,
            'link'              => $model->getDirectionsUrl(),
            'admin_url'         => Backend::url('sas/requests/requests/update/' . $model->id),
            'description'       => $model->description,
            'contact_email'     => @$model->data['contact']['email'],
            'contact_phone'     => @$model->data['contact']['phone'],
        ];

        if (!filter_var($vars['contact_email'], FILTER_VALIDATE_EMAIL)) {
            unset($vars['contact_email']);
        }

        $users = UserRole::where('code', 'volunteer')->first()?->users ?: collect([]);

        Mail::send('sas.requests::mail.request-submitted', $vars, function ($message) use ($vars, $model, $users) {
            // Set the recipient
            if (!$users->count()) {
                $message->to('luke@luketowers.ca');
            } else {
                foreach ($users as $user) {
                    $message->addTo($user->email);
                }
            }

            // Set ReplyTo if present
            if (!empty($vars['contact_email'])) {
                $message->replyTo($vars['contact_email']);
                $message->cc($vars['contact_email']);
            }

            // Attach files if present
            if ($model->photo) {
                $message->attach($model->photo->getLocalPath());
            }
        });

        Flash::success("Your request has been successfully submitted!");

        // Notify the user that their request has been received
        return Redirect::to($this->controller->pageUrl($this->property('redirect')));
    }
}
