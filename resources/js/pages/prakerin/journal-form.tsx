import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

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
    supervising_teacher: Teacher;
    start_date: string;
    end_date: string;
    status: string;
}

interface Journal {
    id: number;
    journal_date: string;
    activities: string;
    learning_outcomes?: string;
    challenges?: string;
    attendance_status: string;
    clock_in?: string;
    clock_out?: string;
}

interface Props {
    placement: Placement;
    existing_journal?: Journal;
    journal_date: string;
    success?: string;
    [key: string]: unknown;
}

export default function JournalForm({ placement, existing_journal, journal_date, success }: Props) {
    const [formData, setFormData] = useState({
        journal_date: existing_journal?.journal_date || journal_date,
        activities: existing_journal?.activities || '',
        learning_outcomes: existing_journal?.learning_outcomes || '',
        challenges: existing_journal?.challenges || '',
        attendance_status: existing_journal?.attendance_status || 'present',
        clock_in: existing_journal?.clock_in || '',
        clock_out: existing_journal?.clock_out || '',
    });

    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setIsSubmitting(true);

        router.post(route('prakerin.store'), formData, {
            preserveState: true,
            preserveScroll: true,
            onFinish: () => setIsSubmitting(false),
            onError: () => setIsSubmitting(false),
        });
    };

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

    return (
        <AppShell>
            <Head title="Jurnal Harian Prakerin" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="bg-gradient-to-r from-green-600 to-blue-600 rounded-lg p-6 text-white">
                    <h1 className="text-3xl font-bold mb-2">📖 Jurnal Harian Prakerin</h1>
                    <p className="text-green-100">Catat aktivitas dan pembelajaran harian Anda</p>
                </div>

                {/* Success Message */}
                {success && (
                    <div className="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        <div className="flex items-center">
                            <span className="text-xl mr-2">✅</span>
                            <span>{success}</span>
                        </div>
                    </div>
                )}

                {/* Placement Info */}
                <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 className="text-xl font-semibold mb-4 flex items-center">
                        📍 Informasi Penempatan
                    </h2>
                    <div className="grid md:grid-cols-2 gap-4">
                        <div>
                            <p className="text-sm text-gray-600 dark:text-gray-400">Perusahaan</p>
                            <p className="font-semibold text-lg">{placement.company.name}</p>
                        </div>
                        <div>
                            <p className="text-sm text-gray-600 dark:text-gray-400">Guru Pembimbing</p>
                            <p className="font-semibold">{placement.supervising_teacher.name}</p>
                        </div>
                        <div>
                            <p className="text-sm text-gray-600 dark:text-gray-400">Periode</p>
                            <p className="font-semibold">
                                {new Date(placement.start_date).toLocaleDateString('id-ID')} - {new Date(placement.end_date).toLocaleDateString('id-ID')}
                            </p>
                        </div>
                        <div>
                            <p className="text-sm text-gray-600 dark:text-gray-400">Status</p>
                            <div className="mt-1">{getStatusBadge(placement.status)}</div>
                        </div>
                    </div>
                </div>

                {/* Journal Form */}
                <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 className="text-xl font-semibold mb-6 flex items-center">
                        📝 {existing_journal ? 'Edit Jurnal' : 'Isi Jurnal Baru'}
                    </h2>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Date */}
                        <div>
                            <label htmlFor="journal_date" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📅 Tanggal
                            </label>
                            <input
                                type="date"
                                id="journal_date"
                                name="journal_date"
                                value={formData.journal_date}
                                onChange={handleInputChange}
                                max={new Date().toISOString().split('T')[0]}
                                className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required
                            />
                        </div>

                        {/* Attendance Status */}
                        <div>
                            <label htmlFor="attendance_status" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📊 Status Kehadiran
                            </label>
                            <select
                                id="attendance_status"
                                name="attendance_status"
                                value={formData.attendance_status}
                                onChange={handleInputChange}
                                className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required
                            >
                                <option value="present">✅ Hadir</option>
                                <option value="absent">❌ Tidak Hadir</option>
                                <option value="sick">🤒 Sakit</option>
                                <option value="permission">📋 Izin</option>
                            </select>
                        </div>

                        {/* Clock In/Out */}
                        <div className="grid md:grid-cols-2 gap-4">
                            <div>
                                <label htmlFor="clock_in" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    🕐 Jam Masuk
                                </label>
                                <input
                                    type="time"
                                    id="clock_in"
                                    name="clock_in"
                                    value={formData.clock_in}
                                    onChange={handleInputChange}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                />
                            </div>
                            <div>
                                <label htmlFor="clock_out" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    🕐 Jam Keluar
                                </label>
                                <input
                                    type="time"
                                    id="clock_out"
                                    name="clock_out"
                                    value={formData.clock_out}
                                    onChange={handleInputChange}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                />
                            </div>
                        </div>

                        {/* Activities */}
                        <div>
                            <label htmlFor="activities" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🔧 Aktivitas/Kegiatan yang Dilakukan *
                            </label>
                            <textarea
                                id="activities"
                                name="activities"
                                value={formData.activities}
                                onChange={handleInputChange}
                                rows={4}
                                placeholder="Ceritakan secara detail aktivitas yang Anda lakukan hari ini..."
                                className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required
                                minLength={10}
                            />
                            <p className="text-xs text-gray-500 mt-1">Minimal 10 karakter</p>
                        </div>

                        {/* Learning Outcomes */}
                        <div>
                            <label htmlFor="learning_outcomes" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🎓 Hasil Pembelajaran
                            </label>
                            <textarea
                                id="learning_outcomes"
                                name="learning_outcomes"
                                value={formData.learning_outcomes}
                                onChange={handleInputChange}
                                rows={3}
                                placeholder="Apa yang Anda pelajari dari aktivitas hari ini?"
                                className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            />
                        </div>

                        {/* Challenges */}
                        <div>
                            <label htmlFor="challenges" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                ⚠️ Tantangan/Kesulitan
                            </label>
                            <textarea
                                id="challenges"
                                name="challenges"
                                value={formData.challenges}
                                onChange={handleInputChange}
                                rows={3}
                                placeholder="Adakah tantangan atau kesulitan yang Anda hadapi?"
                                className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            />
                        </div>

                        {/* Action Buttons */}
                        <div className="flex gap-4 pt-4">
                            <button
                                type="submit"
                                disabled={isSubmitting}
                                className="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors font-medium"
                            >
                                {isSubmitting ? '💾 Menyimpan...' : '💾 Simpan Jurnal'}
                            </button>
                            <a
                                href={route('prakerin.index')}
                                className="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors font-medium text-center"
                            >
                                ↩️ Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </AppShell>
    );
}