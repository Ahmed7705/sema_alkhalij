<x-app-layout title="المدونة الطبية | سيما الخليج">
    <section class="bg-gradient-to-br from-primary to-primary-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10 space-y-4">
            <h1 class="text-4xl sm:text-5xl font-black">المدونة الطبية والإرشادية</h1>
            <p class="text-medical-200 max-w-xl mx-auto">مقالات طبية موثوقة وإرشادات صحية من المتخصصين</p>
        </div>
    </section>
    <section class="py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                $posts = [
                    ['title' => 'أهمية الرعاية الصحية المنزلية لكبار السن', 'excerpt' => 'تعرف على فوائد توفير الرعاية الطبية المنزلية للأشخاص المسنين ومدى تأثيرها على صحتهم النفسية والجسدية.', 'date' => '2026-07-15'],
                    ['title' => 'كل ما تحتاج معرفته عن الفحوصات المخبرية المنزلية', 'excerpt' => 'دليل شامل حول أنواع الفحوصات المخبرية التي يمكن إجراؤها في المنزل ومتى يجب عليك القيام بها.', 'date' => '2026-07-10'],
                    ['title' => 'نصائح ذهبية بعد العمليات الجراحية', 'excerpt' => 'كيف تعتني بنفسك أو بأحد أفراد عائلتك بعد إجراء عملية جراحية مع التمريض المنزلي المتخصص.', 'date' => '2026-07-05'],
                ];
                @endphp
                @foreach($posts as $post)
                <article class="medical-card overflow-hidden group">
                    <div class="h-48 bg-gradient-to-br from-medical-100 to-medical-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-accent/30" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <div class="p-6 space-y-3">
                        <span class="text-[11px] text-gray-400">{{ $post['date'] }}</span>
                        <h3 class="font-bold text-primary text-lg group-hover:text-accent transition-colors leading-snug">{{ $post['title'] }}</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $post['excerpt'] }}</p>
                        <a href="#" class="text-xs font-bold text-accent hover:text-primary transition-colors inline-flex items-center gap-1">اقرأ المقال الكامل &larr;</a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
