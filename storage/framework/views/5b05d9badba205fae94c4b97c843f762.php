<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo \App\Helpers\I18n::t('app.name'); ?></title>
    <link rel="stylesheet" href="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
    
    <?php $__env->startSection('content'); ?>
    <section class="<?php echo e(route('home')); ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="language-switcher mt-4">
                        <a href="?lang=tr" id="lang-tr" class="mr-2">TR</a>
                        <a href="?lang=en" id="lang-en" class="mr-2">EN</a>
                    </div>
                    <h1 data-i18n="app.name"><?php echo \App\Helpers\I18n::t('app.name'); ?></h1>
                </div>
            </div>
        </div>
    </section>
    <?php $__env->stopSection(); ?>

<?php if(Auth::check()): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 data-i18n="contact.title"><?php echo \App\Helpers\I18n::t('contact.title'); ?></h2>
                <form action="<?php echo e(route('contact.send')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="name" data-i18n="contact.name"><?php echo \App\Helpers\I18n::t('contact.name'); ?></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" data-i18n="contact.email"><?php echo \App\Helpers\I18n::t('contact.email'); ?></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message" data-i18n="contact.message"><?php echo \App\Helpers\I18n::t('contact.message'); ?></label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" data-i18n="contact.submit"><?php echo \App\Helpers\I18n::t('contact.submit'); ?></button>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    (function(){
        const defaultLang = '<?php echo e(config('app.locale', 'tr')); ?>';
        function getParam(name){
            const url = new URL(window.location.href);
            return url.searchParams.get(name);
        }

        const lang = getParam('lang') || localStorage.getItem('app_lang') || defaultLang || 'tr';
        try{ localStorage.setItem('app_lang', lang); }catch(e){}

        async function loadTranslations(l){
            try{
                const res = await fetch('/api/translations/locale/' + encodeURIComponent(l));
                if(!res.ok) return;
                const json = await res.json();
                const groups = json.data || {};
                const flat = {};
                for(const group in groups){
                    const items = groups[group] || {};
                    for(const k in items){ flat[k] = items[k]; }
                }

                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if(!key) return;
                    const val = flat[key];
                    if(val !== undefined && val !== null){
                        el.textContent = val;
                    }
                });
            }catch(err){
                console.error('i18n load error', err);
            }
        }

        document.getElementById('lang-tr')?.addEventListener('click', function(e){
            e.preventDefault();
            try{ localStorage.setItem('app_lang','tr'); }catch(_){ }
            const u = new URL(window.location.href);
            u.searchParams.set('lang','tr');
            window.location.href = u.toString();
        });

        document.getElementById('lang-en')?.addEventListener('click', function(e){
            e.preventDefault();
            try{ localStorage.setItem('app_lang','en'); }catch(_){ }
            const u = new URL(window.location.href);
            u.searchParams.set('lang','en');
            window.location.href = u.toString();
        });

        loadTranslations(lang);
    })();
</script>

</body>
</html>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\example-app\resources\views\index.blade.php ENDPATH**/ ?>