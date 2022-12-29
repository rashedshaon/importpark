<?php Block::put('breadcrumb') ?>
    <ul>
        <li>
            <a href="<?= Backend::url('renatio/dynamicpdf/templates/index/layouts') ?>">
                <?= e(trans('renatio.dynamicpdf::lang.layouts.label')) ?>
            </a>
        </li>
        <li><?= e($this->pageTitle) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (! $this->fatalError) : ?>
    <?= Form::open(['class' => 'layout']) ?>

    <div class="layout-row">
        <?= $this->formRender() ?>
    </div>

    <div class="form-buttons pt-4">
        <div class="loading-indicator-container">
            <button type="submit"
                    data-request="onSave"
                    data-hotkey="ctrl+s, cmd+s"
                    data-load-indicator="<?= e(trans('backend::lang.form.creating_name',
                        ['name' => $formRecordName])) ?>"
                    class="btn btn-primary">
                <?= e(trans('backend::lang.form.create')) ?>
            </button>

            <button type="button"
                    data-request="onSave"
                    data-request-data="close:1"
                    data-hotkey="ctrl+enter, cmd+enter"
                    data-load-indicator="<?= e(trans('backend::lang.form.creating_name',
                        ['name' => $formRecordName])) ?>"
                    class="btn btn-default">
                <?= e(trans('backend::lang.form.create_and_close')) ?>
            </button>

            <span class="btn-text">
                <?= e(trans('backend::lang.form.or')) ?>
                <a href="<?= Backend::url('renatio/dynamicpdf/templates/index/layouts') ?>">
                    <?= e(trans('backend::lang.form.cancel')) ?>
                </a>
            </span>
        </div>
    </div>

    <?= Form::close() ?>
<?php else: ?>
    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p>
        <a href="<?= Backend::url('renatio/dynamicpdf/templates/index/layouts') ?>"
           class="btn btn-default">
            <?= e(trans('renatio.dynamicpdf::lang.layouts.return')) ?>
        </a>
    </p>
<?php endif ?>
