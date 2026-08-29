<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterCampaignRequest;
use App\Http\Requests\NewsletterRequest;
use App\Services\NewsletterService;
use App\Types\StatutNewsletter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    protected NewsletterService $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    public function index()
    {
        $newsletters = $this->newsletterService->getAll();
        $stats = $this->newsletterService->getStats();
        $statuts = StatutNewsletter::list();

        return view('newsletter.index', compact('newsletters', 'stats', 'statuts'));
    }

    public function store(NewsletterRequest $request): JsonResponse
    {
        try {
            $newsletter = $this->newsletterService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Abonné ajouté avec succès.',
                'newsletter' => $newsletter,
                'stats' => $this->newsletterService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->newsletterService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Abonné supprimé avec succès.',
                'stats' => $this->newsletterService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function unsubscribe(int $id): JsonResponse
    {
        try {
            $this->newsletterService->unsubscribe($id);
            $newsletter = $this->newsletterService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Abonné désabonné avec succès.',
                'newsletter' => $newsletter,
                'stats' => $this->newsletterService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du désabonnement.',
            ], 500);
        }
    }

    public function resubscribe(int $id): JsonResponse
    {
        try {
            $this->newsletterService->resubscribe($id);
            $newsletter = $this->newsletterService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Abonné réinscrit avec succès.',
                'newsletter' => $newsletter,
                'stats' => $this->newsletterService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la réinscription.',
            ], 500);
        }
    }

    public function export()
    {
        try {
            $content = $this->newsletterService->exportCsv();
            $filename = 'newsletter_abonnes_' . date('Y-m-d_H-i-s') . '.csv';

            return response($content)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erreur lors de l\'export : ' . $e->getMessage());
        }
    }

    public function sendCampaign(NewsletterCampaignRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Récupérer les destinataires
            if ($data['destinataires'] === 'tous') {
                $emails = $this->newsletterService->getAll()->pluck('email')->toArray();
            } else {
                $emails = $this->newsletterService->getActiveEmails();
            }

            if (empty($emails)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun destinataire trouvé.',
                ], 400);
            }

            // Envoyer l'email à chaque destinataire
            $sent = 0;
            $failed = 0;

            foreach ($emails as $email) {
                try {
                    Mail::raw($data['contenu'], function ($message) use ($email, $data) {
                        $message->to($email)
                            ->subject($data['sujet'])
                            ->from(config('mail.from.address'), config('mail.from.name'));
                    });
                    $sent++;
                } catch (\Exception $e) {
                    $failed++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Campagne envoyée avec succès. {$sent} email(s) envoyé(s), {$failed} échec(s).",
                'sent' => $sent,
                'failed' => $failed,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function filter(Request $request): JsonResponse
    {
        $statut = $request->get('statut');

        if ($statut === StatutNewsletter::ACTIF) {
            $newsletters = $this->newsletterService->getActive();
        } elseif ($statut === StatutNewsletter::DESABONNE) {
            $newsletters = $this->newsletterService->getDesabonnes();
        } else {
            $newsletters = $this->newsletterService->getAll();
        }

        $html = view('newsletter._rows', compact('newsletters'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $newsletters->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $newsletters = $this->newsletterService->search($query);

        $html = view('newsletter._rows', compact('newsletters'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $newsletters->count(),
            'query' => $query,
        ]);
    }
}
