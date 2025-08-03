import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="e-Prakerin SMKN 2 Kota Serang">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-blue-50 to-indigo-100 p-6 text-gray-800 lg:justify-center lg:p-8 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100">
                <header className="mb-8 w-full max-w-6xl">
                    <nav className="flex items-center justify-between">
                        <div className="flex items-center gap-3">
                            <div className="h-10 w-10 rounded-lg bg-blue-600 flex items-center justify-center">
                                <span className="text-white font-bold text-lg">📚</span>
                            </div>
                            <div>
                                <h1 className="text-lg font-bold text-gray-900 dark:text-white">e-Prakerin</h1>
                                <p className="text-sm text-gray-600 dark:text-gray-400">SMKN 2 Kota Serang</p>
                            </div>
                        </div>
                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="inline-flex items-center px-4 py-2 text-gray-700 font-medium hover:text-blue-600 transition-colors dark:text-gray-300 dark:hover:text-blue-400"
                                    >
                                        Masuk
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        Daftar
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                <div className="flex w-full max-w-6xl items-center justify-center">
                    <main className="flex w-full flex-col-reverse lg:flex-row items-center gap-12">
                        {/* Hero Content */}
                        <div className="flex-1 text-center lg:text-left">
                            <div className="mb-6">
                                <h1 className="text-4xl lg:text-6xl font-bold mb-4">
                                    <span className="text-blue-600">🏭 e-Prakerin</span>
                                    <br />
                                    <span className="text-gray-900 dark:text-white">SMKN 2 Kota Serang</span>
                                </h1>
                                <p className="text-xl text-gray-600 dark:text-gray-300 leading-relaxed">
                                    Sistem Manajemen Praktik Kerja Industri yang Modern dan Terintegrasi untuk Memantau Perkembangan Siswa
                                </p>
                            </div>

                            {/* Features Grid */}
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                                    <div className="text-3xl mb-3">📖</div>
                                    <h3 className="font-semibold text-lg mb-2">Jurnal Harian Digital</h3>
                                    <p className="text-gray-600 dark:text-gray-400 text-sm">
                                        Siswa dapat mengisi jurnal kegiatan harian secara digital dengan mudah
                                    </p>
                                </div>
                                <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                                    <div className="text-3xl mb-3">👥</div>
                                    <h3 className="font-semibold text-lg mb-2">Monitoring Real-time</h3>
                                    <p className="text-gray-600 dark:text-gray-400 text-sm">
                                        Guru pembimbing dapat memantau aktivitas siswa secara real-time
                                    </p>
                                </div>
                                <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                                    <div className="text-3xl mb-3">🏢</div>
                                    <h3 className="font-semibold text-lg mb-2">Kolaborasi Industri</h3>
                                    <p className="text-gray-600 dark:text-gray-400 text-sm">
                                        Perusahaan dapat memberikan feedback dan penilaian langsung
                                    </p>
                                </div>
                                <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                                    <div className="text-3xl mb-3">📊</div>
                                    <h3 className="font-semibold text-lg mb-2">Laporan Komprehensif</h3>
                                    <p className="text-gray-600 dark:text-gray-400 text-sm">
                                        Dashboard analitik untuk evaluasi dan administrasi yang efektif
                                    </p>
                                </div>
                            </div>

                            {/* User Roles */}
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mb-8">
                                <h3 className="font-semibold text-lg mb-4 text-center">👤 Siapa yang Dapat Menggunakan?</h3>
                                <div className="flex flex-wrap justify-center gap-3">
                                    <span className="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium dark:bg-blue-900 dark:text-blue-200">
                                        Siswa
                                    </span>
                                    <span className="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium dark:bg-green-900 dark:text-green-200">
                                        Guru Pembimbing
                                    </span>
                                    <span className="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium dark:bg-purple-900 dark:text-purple-200">
                                        Wali Kelas
                                    </span>
                                    <span className="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium dark:bg-indigo-900 dark:text-indigo-200">
                                        Wakil Kepala Sekolah
                                    </span>
                                    <span className="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-medium dark:bg-orange-900 dark:text-orange-200">
                                        Perwakilan Perusahaan
                                    </span>
                                </div>
                            </div>

                            {/* CTA */}
                            {!auth.user && (
                                <div className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                    <Link
                                        href={route('register')}
                                        className="inline-flex items-center justify-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        🚀 Mulai Sekarang
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800"
                                    >
                                        Masuk ke Akun
                                    </Link>
                                </div>
                            )}
                        </div>

                        {/* Hero Image/Illustration */}
                        <div className="flex-1 max-w-lg">
                            <div className="bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl p-8 text-white text-center">
                                <div className="text-6xl mb-4">🎓</div>
                                <h3 className="text-2xl font-bold mb-2">Prakerin Digital</h3>
                                <p className="text-blue-100 mb-6">
                                    Transformasi digital untuk pengalaman Prakerin yang lebih efektif dan terukur
                                </p>
                                <div className="flex justify-center space-x-2">
                                    <div className="w-3 h-3 bg-white rounded-full opacity-60"></div>
                                    <div className="w-3 h-3 bg-white rounded-full opacity-80"></div>
                                    <div className="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

                <footer className="mt-16 text-center text-gray-600 dark:text-gray-400">
                    <div className="flex items-center justify-center gap-2 text-sm">
                        <span>© 2024 e-Prakerin SMKN 2 Kota Serang</span>
                        <span>•</span>
                        <span>Sistem Manajemen Prakerin Digital</span>
                    </div>
                </footer>
            </div>
        </>
    );
}