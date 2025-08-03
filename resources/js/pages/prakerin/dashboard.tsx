import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface Stats {
    total_students: number;
    total_companies: number;
    active_placements: number;
    completed_placements: number;
}

interface Student {
    id: number;
    name: string;
    nisn: string;
    class: string;
    major: string;
}

interface Company {
    id: number;
    name: string;
    contact_person: string;
}

interface Teacher {
    id: number;
    name: string;
    nip: string;
}

interface Placement {
    id: number;
    student: Student;
    company: Company;
    supervising_teacher?: Teacher;
    start_date: string;
    end_date: string;
    status: string;
}

interface Journal {
    id: number;
    journal_date: string;
    activities: string;
    attendance_status: string;
}

interface DashboardData {
    current_placement?: Placement;
    recent_journals?: Journal[];
    supervised_placements?: Placement[];
    company_placements?: Placement[];
}

interface Props {
    stats: Stats;
    dashboard_data: DashboardData;
    user_role: string;
    [key: string]: unknown;
}

export default function PrakerinDashboard({ stats, dashboard_data, user_role }: Props) {
    const getStatusBadge = (status: string) => {
        const statusMap = {
            'planned': { label: 'Direncanakan', color: 'bg-yellow-100 text-yellow-800' },
            'ongoing': { label: 'Berlangsung', color: 'bg-green-100 text-green-800' },
            'completed': { label: 'Selesai', color: 'bg-blue-100 text-blue-800' },
            'cancelled': { label: 'Dibatalkan', color: 'bg-red-100 text-red-800' },
        };
        const statusInfo = statusMap[status as keyof typeof statusMap] || { label: status, color: 'bg-gray-100 text-gray-800' };
        return <span className={`px-2 py-1 rounded-full text-xs font-medium ${statusInfo.color}`}>{statusInfo.label}</span>;
    };

    const getAttendanceIcon = (status: string) => {
        const iconMap = {
            'present': '✅',
            'absent': '❌',
            'sick': '🤒',
            'permission': '📋',
        };
        return iconMap[status as keyof typeof iconMap] || '❓';
    };

    return (
        <AppShell>
            <Head title="Dashboard e-Prakerin" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-6 text-white">
                    <h1 className="text-3xl font-bold mb-2">🏭 Dashboard e-Prakerin</h1>
                    <p className="text-blue-100">Sistem Manajemen Praktik Kerja Industri SMKN 2 Kota Serang</p>
                </div>

                {/* Statistics Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <div className="flex items-center">
                            <div className="text-3xl mr-4">👨‍🎓</div>
                            <div>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.total_students}</p>
                                <p className="text-gray-600 dark:text-gray-400">Total Siswa</p>
                            </div>
                        </div>
                    </div>
                    
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <div className="flex items-center">
                            <div className="text-3xl mr-4">🏢</div>
                            <div>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.total_companies}</p>
                                <p className="text-gray-600 dark:text-gray-400">Perusahaan</p>
                            </div>
                        </div>
                    </div>
                    
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <div className="flex items-center">
                            <div className="text-3xl mr-4">🔄</div>
                            <div>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.active_placements}</p>
                                <p className="text-gray-600 dark:text-gray-400">Prakerin Aktif</p>
                            </div>
                        </div>
                    </div>
                    
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <div className="flex items-center">
                            <div className="text-3xl mr-4">✅</div>
                            <div>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.completed_placements}</p>
                                <p className="text-gray-600 dark:text-gray-400">Prakerin Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Student Dashboard */}
                {user_role === 'student' && dashboard_data.current_placement && (
                    <div className="space-y-6">
                        <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                            <h2 className="text-xl font-semibold mb-4 flex items-center">
                                📍 Penempatan Prakerin Anda
                            </h2>
                            <div className="grid md:grid-cols-2 gap-4">
                                <div>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Perusahaan</p>
                                    <p className="font-semibold text-lg">{dashboard_data.current_placement.company.name}</p>
                                </div>
                                <div>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Guru Pembimbing</p>
                                    <p className="font-semibold">{dashboard_data.current_placement.supervising_teacher?.name}</p>
                                </div>
                                <div>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Tanggal Mulai</p>
                                    <p className="font-semibold">{new Date(dashboard_data.current_placement.start_date).toLocaleDateString('id-ID')}</p>
                                </div>
                                <div>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Tanggal Selesai</p>
                                    <p className="font-semibold">{new Date(dashboard_data.current_placement.end_date).toLocaleDateString('id-ID')}</p>
                                </div>
                            </div>
                            <div className="mt-4 flex gap-3">
                                <a
                                    href={route('prakerin.create')}
                                    className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    📖 Isi Jurnal Harian
                                </a>
                                {getStatusBadge(dashboard_data.current_placement.status)}
                            </div>
                        </div>

                        {dashboard_data.recent_journals && dashboard_data.recent_journals.length > 0 && (
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                                <h2 className="text-xl font-semibold mb-4 flex items-center">
                                    📖 Jurnal Terbaru
                                </h2>
                                <div className="space-y-3">
                                    {dashboard_data.recent_journals.map((journal) => (
                                        <div key={journal.id} className="border-l-4 border-blue-500 pl-4 py-2">
                                            <div className="flex items-center justify-between mb-1">
                                                <p className="font-semibold">{new Date(journal.journal_date).toLocaleDateString('id-ID')}</p>
                                                <span className="text-xl">{getAttendanceIcon(journal.attendance_status)}</span>
                                            </div>
                                            <p className="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                                {journal.activities}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                )}

                {/* Teacher Dashboard */}
                {user_role === 'teacher' && dashboard_data.supervised_placements && (
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h2 className="text-xl font-semibold mb-4 flex items-center">
                            👥 Siswa Bimbingan Anda
                        </h2>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead className="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Siswa
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Perusahaan
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Periode
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    {dashboard_data.supervised_placements.map((placement) => (
                                        <tr key={placement.id}>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <div className="text-sm font-medium text-gray-900 dark:text-white">
                                                        {placement.student.name}
                                                    </div>
                                                    <div className="text-sm text-gray-500 dark:text-gray-400">
                                                        {placement.student.class} - {placement.student.major}
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {placement.company.name}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                {getStatusBadge(placement.status)}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {new Date(placement.start_date).toLocaleDateString('id-ID')} - {new Date(placement.end_date).toLocaleDateString('id-ID')}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}

                {/* Company Representative Dashboard */}
                {user_role === 'company_representative' && dashboard_data.company_placements && (
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h2 className="text-xl font-semibold mb-4 flex items-center">
                            🏢 Siswa Prakerin di Perusahaan Anda
                        </h2>
                        <div className="grid gap-4">
                            {dashboard_data.company_placements.map((placement) => (
                                <div key={placement.id} className="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div className="flex items-center justify-between">
                                        <div>
                                            <h3 className="font-semibold text-lg">{placement.student.name}</h3>
                                            <p className="text-gray-600 dark:text-gray-400">
                                                {placement.student.class} - {placement.student.major}
                                            </p>
                                            <p className="text-sm text-gray-500 dark:text-gray-400">
                                                NISN: {placement.student.nisn}
                                            </p>
                                        </div>
                                        <div className="text-right">
                                            {getStatusBadge(placement.status)}
                                            <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                {new Date(placement.start_date).toLocaleDateString('id-ID')} - {new Date(placement.end_date).toLocaleDateString('id-ID')}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                )}

                {/* Quick Actions */}
                <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 className="text-xl font-semibold mb-4">⚡ Aksi Cepat</h2>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {user_role === 'student' && (
                            <a
                                href={route('prakerin.create')}
                                className="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                            >
                                <div className="text-2xl mr-3">📖</div>
                                <div>
                                    <p className="font-semibold">Isi Jurnal</p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Catat aktivitas harian</p>
                                </div>
                            </a>
                        )}
                        
                        <div className="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div className="text-2xl mr-3">📊</div>
                            <div>
                                <p className="font-semibold">Lihat Laporan</p>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Analisis progress</p>
                            </div>
                        </div>
                        
                        <div className="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div className="text-2xl mr-3">💬</div>
                            <div>
                                <p className="font-semibold">Feedback</p>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Berikan penilaian</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}