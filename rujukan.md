# rujukan.md
> System instructions for AI, not standard documentation.

## Context
- I am a [Developer/Super Admin] building `[SiKEM - Sistem Integrasi Kebajikan Mualaf]` for `[Unit Dakwah Pejabat Agama Daerah Manjung]`.
- Main Tech Stack: Laravel 13, TALL Stack (Tailwind, Alpine.js, Livewire), and TailAdmin template integration.
- AI Agents Collaboration: 
  1. Web UI (Gemini Flash / Gemini 3.1 Pro / Claude Sonnet 4.6 / Claude Opus 4.6) for brainstorming & complex logic.
  2. CLI (Claude Opus 4.6) for execution and writing code directly in the directory.
- Communication Tone: Direct, technical, zero fluff. Note that I will prompt you in a mix of English and colloquial Malay (Northern dialect). You must understand the context but avoid using Indonesian terms (e.g., avoid *bikin, perbarui, unduh*) in your responses.

## How I Work (Phased Concept)
- **MANDATORY:** You must work in phases. Do not generate excessively long files or code blocks in a single response.
- **First Task (Phase 1):** Start with the Laravel installation from A-Z (Setup, database config, TailAdmin integration). Stop and wait for my instruction before moving to the next phase.
- Always ask for my confirmation upon completing a phase before proceeding.

## Playbooks & Cross-References
- ERD & Overall Modules: **[MANDATORY REFERENCE]** Always refer to the `sikem_erd.md` file in the root directory.
- **Auto-Update Instruction:** If I instruct any additions, logic changes, or database modifications during our conversation, you are **required** to auto-update the `sikem_erd.md` file automatically so it stays synced with the latest context.
- Initial Data Setup (Seeder):
  - Super Admin Login: `basyid90@gmail.com`
  - Password: `901022aspura`

## Do Not
- ❌ Do not invent database structures that deviate from `sikem_erd.md`.
- ❌ Do not provide lengthy explanations. Focus strictly on terminal commands and code blocks.
- ❌ Do not modify existing files or code without referencing or briefly stating which part is being touched.

## How to Ask
- ✅ Stop before: Doing a major rewrite or moving to a new phase.
- ✅ Phase completion: Ask "Phase completed. Should we proceed to the next phase?"
- ✅ Blocked/Confused?: Ask ONE sharp and specific question. Do not guess blindly.

- UI Requirement: MANDATORY to strictly use the existing TailAdmin UI components. Do not invent custom UI design if a TailAdmin equivalent exists.